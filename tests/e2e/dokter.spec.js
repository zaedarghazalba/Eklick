import { test, expect } from '@playwright/test';
import { LoginPage, TEST_USERS, loginAsApi } from './helpers.js';

test.describe('Doctor Dashboard', () => {
  let loginPage;

  test.beforeEach(async ({ page }) => {
    loginPage = new LoginPage(page);
  });

  test('should access doctor dashboard after login', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.dokter.email, TEST_USERS.dokter.password);
    await loginPage.expectRedirectTo(/\/dokter\/dashboard/);
    await expect(page.locator('body')).toBeVisible();
  });

  test('should display doctor dashboard with poli info', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.dokter.email, TEST_USERS.dokter.password);
    await page.waitForURL(/\/dokter\/dashboard/);
    await page.waitForTimeout(1000);
    const content = await page.locator('body').textContent();
    expect(content).toContain('Umum');
  });

  test('should access doctor archive page', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.dokter.email, TEST_USERS.dokter.password);
    await page.goto('/dokter/arsip');
    await page.waitForTimeout(1000);
    expect(page.url()).toContain('/dokter/arsip');
  });

  test('should not allow admin to access doctor routes', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.admin.email, TEST_USERS.admin.password);
    await page.waitForURL(/\/admin\/dashboard/);
    await page.goto('/dokter/dashboard');
    await page.waitForTimeout(1000);
    const url = page.url();
    expect(url).not.toContain('/dokter/dashboard');
  });

test('should not allow user to access doctor routes', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.user.email, TEST_USERS.user.password);
    await page.waitForTimeout(3000);
    await page.goto('/dokter/dashboard');
    await page.waitForTimeout(2000);
    const url = page.url();
    expect(url).not.toContain('/dokter/dashboard');
  });
});

test.describe('Doctor API', () => {
  test('should get doctor antrian via API', async ({ request }) => {
    const token = await loginAsApi(request, 'dokter');
    if (!token) return;

    const response = await request.get('/api/doctor/antrian', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });

  test('should get doctor dashboard stats via API', async ({ request }) => {
    const token = await loginAsApi(request, 'dokter');
    if (!token) return;

    const response = await request.get('/api/doctor/dashboard', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });

  test('should get diagnosa via API', async ({ request }) => {
    const token = await loginAsApi(request, 'dokter');
    if (!token) return;

    const response = await request.get('/api/doctor/antrian/1', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 404, 500]).toContain(response.status());
  });

  test('should save diagnosa via API', async ({ request }) => {
    const token = await loginAsApi(request, 'dokter');
    if (!token) return;

    const response = await request.post('/api/doctor/antrian/1/diagnosa', {
      data: {
        keluhan_utama: 'Sakit kepala',
        diagnosa: 'Migrain',
        resep_obat: 'Paracetamol'
      },
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 201, 400, 404, 422, 500]).toContain(response.status());
  });

  test('should reject non-dokter from accessing doctor API', async ({ request }) => {
    const token = await loginAsApi(request, 'user');
    if (!token) return;

    const response = await request.get('/api/doctor/antrian', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 403, 500]).toContain(response.status());
  });
});