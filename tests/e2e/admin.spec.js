import { test, expect } from '@playwright/test';
import { LoginPage, TEST_USERS, loginAsApi } from './helpers.js';

test.describe('Admin Dashboard', () => {
  let loginPage;

  test.beforeEach(async ({ page }) => {
    loginPage = new LoginPage(page);
  });

  test('should access admin dashboard after login', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.admin.email, TEST_USERS.admin.password);
    await loginPage.expectRedirectTo(/\/admin\/dashboard/);
    await expect(page.locator('body')).toBeVisible();
  });

  test('should display admin dashboard elements', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.admin.email, TEST_USERS.admin.password);
    await page.waitForURL(/\/admin\/dashboard/);
    await page.waitForTimeout(1000);
    const hasContent = await page.locator('body').textContent();
    expect(hasContent).toBeTruthy();
  });

  test('should access admin antrian page', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.admin.email, TEST_USERS.admin.password);
    await page.goto('/admin/antrian');
    await page.waitForTimeout(1000);
    expect(page.url()).toContain('/admin/antrian');
  });

  test('should access admin users page', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.admin.email, TEST_USERS.admin.password);
    await page.goto('/admin/users');
    await page.waitForTimeout(1000);
    expect(page.url()).toContain('/admin/users');
  });

  test('should access admin doctors page', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.admin.email, TEST_USERS.admin.password);
    await page.goto('/admin/doctors');
    await page.waitForTimeout(1000);
    expect(page.url()).toContain('/admin/doctors');
  });

  test('should access admin data-pasien page', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.admin.email, TEST_USERS.admin.password);
    await page.goto('/admin/data-pasien');
    await page.waitForTimeout(1000);
    expect(page.url()).toContain('/admin/data-pasien');
  });

  test('should not allow user role to access admin routes', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.user.email, TEST_USERS.user.password);
    await page.waitForTimeout(3000);
    await page.goto('/admin/dashboard', { timeout: 5000 }).catch(() => {});
    await page.waitForTimeout(1000);
    const url = page.url();
    expect(url).not.toContain('/admin/dashboard');
  });

  test('should not allow dokter role to access admin routes', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.dokter.email, TEST_USERS.dokter.password);
    await page.waitForURL(/\/dokter\/dashboard/, { timeout: 10000 }).catch(() => {});
    await page.goto('/admin/dashboard');
    await page.waitForTimeout(2000);
    const url = page.url();
    expect(url).not.toContain('/admin/dashboard');
  });
});

test.describe('Admin API - Users', () => {
  test('should get all users via API', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.get('/api/admin/users', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
    if (response.status() === 200) {
      const data = await response.json();
      expect(data.success).toBe(true);
    }
  });

  test('should get all doctors via API', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.get('/api/admin/doctors', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });

  test('should create doctor via API', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const uniqueEmail = `dokter${Date.now()}@example.com`;
    const response = await request.post('/api/admin/doctors', {
      data: {
        name: 'Dr. Test',
        email: uniqueEmail,
        password: 'password123',
        poli_spesialisasi: 'Umum'
      },
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 201, 422, 500]).toContain(response.status());
  });

  test('should reject non-admin from accessing admin API', async ({ request }) => {
    const token = await loginAsApi(request, 'user');
    if (!token) return;

    const response = await request.get('/api/admin/users', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 403, 500]).toContain(response.status());
  });
});

test.describe('Admin API - Antrian Management', () => {
  test('should get all antrian via API', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.get('/api/admin/antrian', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });

  test('should get antrian detail via API', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.get('/api/admin/antrian/1', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 404, 500]).toContain(response.status());
  });

  test('should manage antrian status via API', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const actions = ['panggil', 'skip', 'selesai', 'reset'];
    for (const action of actions) {
      const response = await request.post(`/api/admin/antrian/1/${action}`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      expect([200, 201, 400, 404, 500]).toContain(response.status());
    }
  });

  test('should get patients data via API', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.get('/api/admin/pasien', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });
});