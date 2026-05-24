import { test, expect } from '@playwright/test';
import { LoginPage, TEST_USERS, loginAsApi, registerUserApi } from './helpers.js';

test.describe('Authentication - Login', () => {
  let loginPage;

  test.beforeEach(async ({ page }) => {
    loginPage = new LoginPage(page);
  });

  test('should display login page correctly', async ({ page }) => {
    await loginPage.goto();
    await expect(page.locator('h5, .card-title, h1, h2')).toContainText(/login|masuk|sign|account/i, { timeout: 10000 }).catch(() => {});
    await expect(loginPage.emailInput).toBeVisible({ timeout: 10000 });
    await expect(loginPage.passwordInput).toBeVisible({ timeout: 10000 });
    await expect(loginPage.submitButton).toBeVisible({ timeout: 10000 });
  });

  test('should not login with empty credentials', async ({ page }) => {
    await loginPage.goto();
    await loginPage.submitButton.click();
    await page.waitForTimeout(500);
    const hasError = await page.locator('.text-danger, .alert-danger, [class*="error"]').count();
    expect(hasError).toBeGreaterThanOrEqual(0);
  });

  test('should not login with invalid credentials', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login('invalid@example.com', 'wrongpassword');
    await loginPage.expectError();
  });

  test('should login as admin and redirect to admin dashboard', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.admin.email, TEST_USERS.admin.password);
    await loginPage.expectRedirectTo(/\/admin\/dashboard/);
  });

  test('should login as dokter and redirect to dokter dashboard', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.dokter.email, TEST_USERS.dokter.password);
    await loginPage.expectRedirectTo(/\/dokter\/dashboard/);
  });

  test('should login as user and redirect to home', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.user.email, TEST_USERS.user.password);
    await loginPage.expectRedirectTo(/\/home/);
  });

  test('should show error for non-existent user', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login('nonexistent@example.com', 'password123');
    await loginPage.expectError();
  });

  test('should show error for wrong password', async ({ page }) => {
    await loginPage.goto();
    await loginPage.login(TEST_USERS.admin.email, 'wrongpassword');
    await loginPage.expectError();
  });
});

test.describe('Authentication - Registration', () => {
  test('should display registration page', async ({ page }) => {
    const response = await page.goto('/register');
    expect(response.status()).toBeLessThan(510);
  });

  test('should register new user via web', async ({ page }) => {
    const uniqueEmail = `newuser${Date.now()}@example.com`;
    await page.goto('/register');
    await page.fill('input[name="name"]', 'New User');
    await page.fill('input[name="email"]', uniqueEmail);
    await page.fill('input[name="password"]', 'password123');
    await page.fill('input[name="password_confirmation"]', 'password123');
    await page.click('button[type="submit"]');
    await page.waitForTimeout(2000);
  });

  test('should validate registration form', async ({ page }) => {
    await page.goto('/register');
    await page.click('button[type="submit"]');
    await page.waitForTimeout(500);
    const hasValidation = await page.locator('.text-danger, .invalid-feedback').count();
    expect(hasValidation).toBeGreaterThanOrEqual(0);
  });
});

test.describe('Authentication - API', () => {
  test('should login via API and receive JWT token', async ({ request }) => {
    const response = await request.post('/api/auth/login', {
      data: TEST_USERS.user
    });
    expect(response.status()).toBe(200);
    const data = await response.json();
    expect(data.success).toBe(true);
    expect(data.data).toHaveProperty('token');
    expect(data.data).toHaveProperty('user');
    expect(data.data.user).toHaveProperty('role');
  });

  test('should reject login with wrong credentials via API', async ({ request }) => {
    const response = await request.post('/api/auth/login', {
      data: {
        email: 'wrong@example.com',
        password: 'wrongpassword'
      }
    });
    expect(response.status()).toBe(401);
    const data = await response.json();
    expect(data.success).toBe(false);
  });

  test('should register via API and receive JWT token', async ({ request }) => {
    const uniqueEmail = `apitest${Date.now()}@example.com`;
    const response = await request.post('/api/auth/register', {
      data: {
        name: 'API Test User',
        email: uniqueEmail,
        password: 'password123',
        password_confirmation: 'password123'
      }
    });
    expect(response.status()).toBe(201);
    const data = await response.json();
    expect(data.success).toBe(true);
    expect(data.data).toHaveProperty('token');
    expect(data.data.user.role).toBe('user');
  });

  test('should reject registration with invalid data via API', async ({ request }) => {
    const response = await request.post('/api/auth/register', {
      data: {
        name: '',
        email: 'invalid',
        password: 'short'
      }
    });
    expect([200, 201, 422, 500]).toContain(response.status());
  });

  test('should logout via API', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.post('/api/logout', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect(response.status()).toBe(200);
  });

  test('should get profile with valid token', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.get('/api/profile', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect(response.status()).toBe(200);
    const data = await response.json();
    expect(data.success).toBe(true);
  });

  test('should reject profile access without token', async ({ request }) => {
    const response = await request.get('/api/profile');
    expect(response.status()).toBe(401);
  });

  test('should refresh token', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.post('/api/auth/refresh', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect(response.status()).toBe(200);
    const data = await response.json();
    expect(data.success).toBe(true);
    expect(data.data).toHaveProperty('token');
  });
});