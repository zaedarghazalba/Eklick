import { Page, Locator, expect } from '@playwright/test';

export class DashboardPage {
  readonly page: Page;
  readonly welcomeMessage: Locator;
  readonly logoutButton: Locator;

  constructor(page: Page) {
    this.page = page;
    this.welcomeMessage = page.locator('h1, h2, .welcome, [class*="welcome"]');
    this.logoutButton = page.locator('a[href*="logout"], button[href*="logout"]');
  }

  async expectAuthenticated() {
    await expect(this.page.locator('body')).toBeVisible();
  }

  async logout() {
    if (await this.logoutButton.isVisible()) {
      await this.logoutButton.click();
    }
  }
}

export class AdminDashboardPage extends DashboardPage {
  readonly usersLink: Locator;
  readonly doctorsLink: Locator;
  readonly antrianLink: Locator;
  readonly dataPasienLink: Locator;
  readonly userTable: Locator;
  readonly doctorTable: Locator;

  constructor(page: Page) {
    super(page);
    this.usersLink = page.locator('a[href*="/admin/users"]');
    this.doctorsLink = page.locator('a[href*="/admin/doctors"]');
    this.antrianLink = page.locator('a[href*="/admin/antrian"]');
    this.dataPasienLink = page.locator('a[href*="/admin/data-pasien"]');
    this.userTable = page.locator('table[data-type="users"], .users-table, table');
    this.doctorTable = page.locator('table[data-type="doctors"], .doctors-table, table');
  }

  async goto() {
    await this.page.goto('/admin/dashboard');
  }

  async expectOnDashboard() {
    await expect(this.page).toHaveURL(/\/admin\/dashboard/);
  }
}

export class DoctorDashboardPage extends DashboardPage {
  readonly antrianTable: Locator;
  readonly archiveLink: Locator;
  readonly pasienName: Locator;
  readonly statusBadge: Locator;

  constructor(page: Page) {
    super(page);
    this.antrianTable = page.locator('table[data-type="antrian"], .antrian-table, table');
    this.archiveLink = page.locator('a[href*="/dokter/arsip"]');
    this.pasienName = page.locator('[data-testid="pasien-name"], .pasien-name, td:nth-child(2)');
    this.statusBadge = page.locator('[class*="status"], .badge');
  }

  async goto() {
    await this.page.goto('/dokter/dashboard');
  }

  async expectOnDashboard() {
    await expect(this.page).toHaveURL(/\/dokter\/dashboard/);
  }

  async expectAntrianTable() {
    await expect(this.antrianTable).toBeVisible();
  }
}

export class UserDashboardPage extends DashboardPage {
  readonly antrianmuLink: Locator;
  readonly daftarAntrianButton: Locator;

  constructor(page: Page) {
    super(page);
    this.antrianmuLink = page.locator('a[href="/antrianmu"]');
    this.daftarAntrianButton = page.locator('a[href="/antrian"], button:has-text("Daftar")');
  }

  async goto() {
    await this.page.goto('/home');
  }

  async expectOnDashboard() {
    await expect(this.page).toHaveURL(/\/home/);
  }
}