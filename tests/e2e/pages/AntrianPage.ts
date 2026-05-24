import { Page, Locator, expect } from '@playwright/test';

export class AntrianFormPage {
  readonly page: Page;
  readonly poliSelect: Locator;
  readonly tanggalInput: Locator;
  readonly namaInput: Locator;
  readonly noKtpInput: Locator;
  readonly alamatInput: Locator;
  readonly jenisKelaminSelect: Locator;
  readonly noHpInput: Locator;
  readonly tglLahirInput: Locator;
  readonly pekerjaanInput: Locator;
  readonly rekamMedisInput: Locator;
  readonly submitButton: Locator;
  readonly successMessage: Locator;
  readonly errorMessage: Locator;

  constructor(page: Page) {
    this.page = page;
    this.poliSelect = page.locator('select[name="poli"], #poli');
    this.tanggalInput = page.locator('input[name="tanggal_daftar"], #tanggal_daftar');
    this.namaInput = page.locator('input[name="nama"], #nama');
    this.noKtpInput = page.locator('input[name="no_ktp"], #no_ktp');
    this.alamatInput = page.locator('input[name="alamat"], #alamat, textarea[name="alamat"]');
    this.jenisKelaminSelect = page.locator('select[name="jenis_kelamin"], #jenis_kelamin');
    this.noHpInput = page.locator('input[name="no_hp"], #no_hp');
    this.tglLahirInput = page.locator('input[name="tgl_lahir"], #tgl_lahir');
    this.pekerjaanInput = page.locator('input[name="pekerjaan"], #pekerjaan');
    this.rekamMedisInput = page.locator('input[name="rekam_medis"], #rekam_medis');
    this.submitButton = page.locator('button[type="submit"], input[type="submit"]');
    this.successMessage = page.locator('.alert-success, .text-success, [class*="success"]');
    this.errorMessage = page.locator('.alert-danger, .text-danger, [class*="error"]');
  }

  async goto() {
    await this.page.goto('/antrian');
  }

  async fillForm(data: {
    poli?: string;
    tanggal_daftar?: string;
    nama?: string;
    no_ktp?: string;
    alamat?: string;
    jenis_kelamin?: string;
    no_hp?: string;
    tgl_lahir?: string;
    pekerjaan?: string;
  }) {
    if (data.poli) await this.poliSelect.selectOption(data.poli);
    if (data.tanggal_daftar) await this.tanggalInput.fill(data.tanggal_daftar);
    if (data.nama) await this.namaInput.fill(data.nama);
    if (data.no_ktp) await this.noKtpInput.fill(data.no_ktp);
    if (data.alamat) await this.alamatInput.fill(data.alamat);
    if (data.jenis_kelamin) await this.jenisKelaminSelect.selectOption(data.jenis_kelamin);
    if (data.no_hp) await this.noHpInput.fill(data.no_hp);
    if (data.tgl_lahir) await this.tglLahirInput.fill(data.tgl_lahir);
    if (data.pekerjaan) await this.pekerjaanInput.fill(data.pekerjaan);
  }

  async submit() {
    await this.submitButton.click();
  }

  async expectSuccess() {
    await expect(this.successMessage.first()).toBeVisible({ timeout: 10000 });
  }

  async expectError() {
    await expect(this.errorMessage.first()).toBeVisible({ timeout: 5000 });
  }
}

export class AntrianListPage {
  readonly page: Page;
  readonly antrianTable: Locator;
  readonly poliFilter: Locator;
  readonly dateFilter: Locator;
  readonly noAntrianCell: Locator;
  readonly poliCell: Locator;
  readonly namaCell: Locator;
  readonly statusBadge: Locator;

  constructor(page: Page) {
    this.page = page;
    this.antrianTable = page.locator('table[data-type="antrian"], table');
    this.poliFilter = page.locator('select[name="poli"], #poli-filter');
    this.dateFilter = page.locator('input[name="tanggal"], #tanggal-filter');
    this.noAntrianCell = page.locator('td:nth-child(1), [data-testid="no-antrian"]');
    this.poliCell = page.locator('td:nth-child(2), [data-testid="poli"]');
    this.namaCell = page.locator('td:nth-child(3), [data-testid="nama"]');
    this.statusBadge = page.locator('[class*="status"], .badge');
  }

  async goto() {
    await this.page.goto('/antrian');
  }

  async expectTable() {
    await expect(this.antrianTable).toBeVisible();
  }

  async getFirstAntrianNo() {
    const cell = this.noAntrianCell.first();
    return await cell.textContent();
  }
}

export class AntrianMuPage {
  readonly page: Page;
  readonly antrianList: Locator;
  readonly noAntrianCell: Locator;
  readonly poliCell: Locator;
  readonly statusBadge: Locator;
  readonly emptyMessage: Locator;

  constructor(page: Page) {
    this.page = page;
    this.antrianList = page.locator('table[data-type="my-antrian"], table');
    this.noAntrianCell = page.locator('[data-testid="no-antrian"], td:nth-child(1)');
    this.poliCell = page.locator('[data-testid="poli"], td:nth-child(2)');
    this.statusBadge = page.locator('[class*="status"], .badge');
    this.emptyMessage = page.locator('.empty, [class*="empty"], p:has-text("belum")');
  }

  async goto() {
    await this.page.goto('/antrianmu');
  }

  async expectOnPage() {
    await expect(this.page).toHaveURL(/\/antrianmu/);
  }

  async getAntrianCount() {
    return await this.noAntrianCell.count();
  }
}

export class AdminAntrianPage {
  readonly page: Page;
  readonly antrianTable: Locator;
  readonly panggilButtons: Locator;
  readonly skipButtons: Locator;
  readonly selesaiButtons: Locator;
  readonly resetButtons: Locator;
  readonly deleteButtons: Locator;

  constructor(page: Page) {
    this.page = page;
    this.antrianTable = page.locator('table[data-type="admin-antrian"], table');
    this.panggilButtons = page.locator('button:has-text("Panggil"), [data-action="panggil"]');
    this.skipButtons = page.locator('button:has-text("Skip"), [data-action="skip"]');
    this.selesaiButtons = page.locator('button:has-text("Selesai"), [data-action="selesai"]');
    this.resetButtons = page.locator('button:has-text("Reset"), [data-action="reset"]');
    this.deleteButtons = page.locator('button:has-text("Hapus"), [data-action="delete"]');
  }

  async goto() {
    await this.page.goto('/admin/antrian');
  }

  async expectTable() {
    await expect(this.antrianTable).toBeVisible();
  }

  async getFirstAntrianId() {
    const row = this.antrianTable.locator('tbody tr').first();
    const idCell = row.locator('td').first();
    return await idCell.textContent();
  }
}

export class DoctorAntrianPage {
  readonly page: Page;
  readonly antrianTable: Locator;
  readonly namaPasienCell: Locator;
  readonly diagnosaButton: Locator;
  readonly uploadButton: Locator;

  constructor(page: Page) {
    this.page = page;
    this.antrianTable = page.locator('table[data-type="doctor-antrian"], table');
    this.namaPasienCell = page.locator('[data-testid="nama-pasien"], td:nth-child(2)');
    this.diagnosaButton = page.locator('button:has-text("Diagnosa"), [data-action="diagnosa"]');
    this.uploadButton = page.locator('button:has-text("Upload"), [data-action="upload"]');
  }

  async goto() {
    await this.page.goto('/dokter/dashboard');
  }

  async expectTable() {
    await expect(this.antrianTable).toBeVisible();
  }
}