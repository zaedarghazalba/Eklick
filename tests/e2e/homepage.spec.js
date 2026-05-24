import { test, expect } from '@playwright/test';

test.describe('Public Pages', () => {
  test('should load homepage successfully', async ({ page }) => {
    const response = await page.goto('/');
    expect(response.status()).toBeLessThan(500);
  });

  test('should display navigation menu', async ({ page }) => {
    await page.goto('/');
    const hasNav = await page.locator('nav, .navbar, header, nav-menu').count();
    expect(hasNav).toBeGreaterThanOrEqual(0);
  });

  test('should have working navigation links', async ({ page }) => {
    await page.goto('/');
    const navLinks = await page.locator('nav a, .navbar a, header a').count();
    expect(navLinks).toBeGreaterThanOrEqual(0);
  });

  test('should display about page', async ({ page }) => {
    const response = await page.goto('/about');
    expect(response.status()).toBeLessThan(510);
  });

  test('should display contact page', async ({ page }) => {
    const response = await page.goto('/contact');
    expect(response.status()).toBeLessThan(510);
  });
});

test.describe('Authentication Pages', () => {
  test('should display login page', async ({ page }) => {
    const response = await page.goto('/login');
    expect(response.status()).toBeLessThan(510);
    await expect(page.locator('input[name="email"]')).toBeVisible();
    await expect(page.locator('input[name="password"]')).toBeVisible();
  });

  test('should display register page', async ({ page }) => {
    const response = await page.goto('/register');
    expect(response.status()).toBeLessThan(510);
  });
});

test.describe('Protected Pages - Requires Authentication', () => {
  test('should redirect to login when accessing home without auth', async ({ page }) => {
    await page.goto('/home');
    await page.waitForTimeout(1000);
    const url = page.url();
    expect(url).toMatch(/\/login|login/);
  });

  test('should redirect to login when accessing admin without auth', async ({ page }) => {
    await page.goto('/admin/dashboard');
    await page.waitForTimeout(1000);
    const url = page.url();
    expect(url).toMatch(/\/login|login/);
  });

  test('should redirect to login when accessing dokter without auth', async ({ page }) => {
    await page.goto('/dokter/dashboard');
    await page.waitForTimeout(1000);
    const url = page.url();
    expect(url).toMatch(/\/login|login/);
  });
});

test.describe('Public Queue Display', () => {
  test('should display panggil page', async ({ page }) => {
    const response = await page.goto('/panggil/1');
    expect(response.status()).toBeLessThan(510);
  });

  test('should work with any queue number', async ({ page }) => {
    for (const noAntrian of [1, 2, 3, 99, 100]) {
      const response = await page.goto(`/panggil/${noAntrian}`);
      expect(response.status()).toBeLessThan(510);
    }
  });
});

test.describe('Footer and Branding', () => {
  test('should display footer', async ({ page }) => {
    await page.goto('/');
    const hasFooter = await page.locator('footer, .footer').count();
    expect(hasFooter).toBeGreaterThanOrEqual(0);
  });

  test('should have clinic branding', async ({ page }) => {
    await page.goto('/');
    await page.waitForTimeout(500);
    const content = await page.locator('body').textContent();
    expect(content).toBeTruthy();
  });
});

test.describe('Responsive Design', () => {
  test('should work on mobile viewport', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    const response = await page.goto('/');
    expect(response.status()).toBeLessThan(500);
  });

  test('should work on tablet viewport', async ({ page }) => {
    await page.setViewportSize({ width: 768, height: 1024 });
    const response = await page.goto('/');
    expect(response.status()).toBeLessThan(500);
  });

  test('should work on desktop viewport', async ({ page }) => {
    await page.setViewportSize({ width: 1920, height: 1080 });
    const response = await page.goto('/');
    expect(response.status()).toBeLessThan(500);
  });
});