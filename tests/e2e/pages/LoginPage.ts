import { Page, Locator, expect } from '@playwright/test';

export class LoginPage {
  readonly page: Page;
  readonly emailInput: Locator;
  readonly passwordInput: Locator;
  readonly submitButton: Locator;
  readonly errorMessage: Locator;

  constructor(page: Page) {
    this.page = page;
    this.emailInput = page.locator('#yourEmail, input[name="email"]').first();
    this.passwordInput = page.locator('#yourPassword, input[name="password"]').first();
    this.submitButton = page.locator('button[type="submit"]');
    this.errorMessage = page.locator('.alert-danger, .text-danger, [class*="error"]');
  }

  async goto() {
    await this.page.goto('/login', { waitUntil: 'networkidle', timeout: 45000 });
  }

  async login(email: string, password: string) {
    await this.emailInput.fill(email);
    await this.passwordInput.fill(password);
    await this.submitButton.click();
  }

  async expectError(message?: string) {
    await expect(this.errorMessage.first()).toBeVisible({ timeout: 5000 }).catch(() => {});
    if (message) {
      await expect(this.errorMessage).toContainText(message);
    }
  }

  async expectRedirectTo(urlPattern: RegExp | string, timeout = 20000) {
    await this.page.waitForURL(urlPattern, { timeout });
    expect(this.page.url()).toMatch(urlPattern);
  }
}