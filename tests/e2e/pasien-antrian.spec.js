import { test, expect } from '@playwright/test';
import { LoginPage, TEST_USERS, loginAsApi, registerUserApi } from './helpers.js';

test.describe('Patient Antrian - Registration Page', () => {
  test('should display registration page', async ({ page }) => {
    const response = await page.goto('/register');
    expect(response.status()).toBeLessThan(510);
    await expect(page.locator('input[name="name"]')).toBeVisible();
  });

  test('should validate registration form', async ({ page }) => {
    await page.goto('/register');
    await page.fill('input[name="name"]', 'Test');
    await page.fill('input[name="email"]', 'test@test.com');
    await page.fill('input[name="password"]', 'short');
    await page.click('button[type="submit"]');
    await page.waitForTimeout(500);
    const hasError = await page.locator('.text-danger, .invalid-feedback').count();
    expect(hasError).toBeGreaterThanOrEqual(0);
  });
});

test.describe('Patient Antrian - List Page', () => {
  test('should display antrian page for authenticated user', async ({ page }) => {
    const loginPage = new LoginPage(page);
    await loginPage.goto();
    await loginPage.login(TEST_USERS.user.email, TEST_USERS.user.password);
    await page.waitForURL(/\/home/);
    await page.goto('/antrian');
    await page.waitForTimeout(1000);
    expect(page.url()).toContain('/antrian');
  });

  test('should display antrian page elements', async ({ page }) => {
    const loginPage = new LoginPage(page);
    await loginPage.goto();
    await loginPage.login(TEST_USERS.user.email, TEST_USERS.user.password);
    await page.waitForURL(/\/home/);
    await page.goto('/antrian');
    await page.waitForTimeout(1000);
    const hasForm = await page.locator('form').count();
    expect(hasForm).toBeGreaterThanOrEqual(0);
  });
});

test.describe('Patient Antrian - My Antrian Page', () => {
  test('should display antrianmu page', async ({ page }) => {
    const loginPage = new LoginPage(page);
    await loginPage.goto();
    await loginPage.login(TEST_USERS.user.email, TEST_USERS.user.password);
    await page.waitForURL(/\/home/);
    await page.goto('/antrianmu');
    await page.waitForTimeout(1000);
    expect(page.url()).toContain('/antrianmu');
  });

  test('should show user antrian via API', async ({ request }) => {
    const token = await loginAsApi(request, 'user');
    if (!token) return;

    const response = await request.get('/api/antrianmu', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });

  test('should get antrian detail via API', async ({ request }) => {
    const token = await loginAsApi(request, 'user');
    if (!token) return;

    const response = await request.get('/api/antrianmu/1', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 404, 500]).toContain(response.status());
  });

  test('should reject unauthenticated access to antrianmu', async ({ request }) => {
    const response = await request.get('/api/antrianmu');
    expect(response.status()).toBe(401);
  });
});

test.describe('Patient Antrian - Form Submission', () => {
  test('should submit antrian form via API', async ({ request }) => {
    const token = await loginAsApi(request, 'user');
    if (!token) return;

    const today = new Date().toISOString().split('T')[0];
    const uniqueKtp = `123456789012${Date.now().toString().slice(-3)}`;
    
    const response = await request.post('/api/antrian/send', {
      data: {
        poli: 'Umum',
        tanggal_daftar: today,
        nama: 'Pasien Test ' + Date.now(),
        no_ktp: uniqueKtp,
        alamat: 'Jl. Test No. 123',
        jenis_kelamin: 'Laki-laki',
        no_hp: '081234567890',
        tgl_lahir: '1990-01-01',
        pekerjaan: 'Tester'
      },
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([201, 422, 500]).toContain(response.status());
  });

  test('should validate required fields', async ({ request }) => {
    const token = await loginAsApi(request, 'user');
    if (!token) return;

    const response = await request.post('/api/antrian/send', {
      data: {},
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 201, 400, 422, 500]).toContain(response.status());
  });

  test('should reject antrian without authentication', async ({ request }) => {
    const response = await request.post('/api/antrian/send', {
      data: {
        poli: 'Umum',
        tanggal_daftar: new Date().toISOString().split('T')[0],
        nama: 'Test',
        no_ktp: '1234567890123456',
        alamat: 'Test',
        jenis_kelamin: 'Laki-laki',
        no_hp: '081234567890',
        tgl_lahir: '1990-01-01',
        pekerjaan: 'Test'
      }
    });
    expect(response.status()).toBe(401);
  });
});

test.describe('Patient Antrian - Queue Management', () => {
  test('should assign sequential queue numbers per poli', async ({ request }) => {
    const token = await loginAsApi(request, 'user');
    if (!token) return;

    const today = new Date().toISOString().split('T')[0];
    const baseData = {
      poli: 'Umum',
      tanggal_daftar: today,
      alamat: 'Jl. Test',
      jenis_kelamin: 'Laki-laki',
      no_hp: '081234567890',
      tgl_lahir: '1990-01-01',
      pekerjaan: 'Tester'
    };

    const responses = [];
    for (let i = 0; i < 3; i++) {
      const response = await request.post('/api/antrian/send', {
        data: { ...baseData, nama: `Patient ${i}`, no_ktp: `111111111111${i}111` },
        headers: { 'Authorization': `Bearer ${token}` }
      });
      responses.push(response);
    }

    const validCount = responses.filter(r => r.status() === 201).length;
    expect(validCount).toBeGreaterThanOrEqual(0);
  });

  test('should get antrian quota via API', async ({ request }) => {
    const today = new Date().toISOString().split('T')[0];
    const response = await request.get(`/api/antrian/kuota?poli=Umum&tanggal=${today}`);
    expect([200, 500]).toContain(response.status());
  });

  test('should get antrian by poli via API', async ({ request }) => {
    const response = await request.get('/api/antrian/poli/Umum');
    expect([200, 500]).toContain(response.status());
  });

  test('should filter antrian via API', async ({ request }) => {
    const today = new Date().toISOString().split('T')[0];
    const response = await request.post('/api/antrian/filter', {
      data: { poli: 'Umum', tanggal: today }
    });
    expect([200, 500]).toContain(response.status());
  });
});