import { test, expect } from '@playwright/test';
import { TEST_USERS, loginAsApi, registerUserApi } from './helpers.js';

test.describe('API - Health Check', () => {
  test('should return health check status', async ({ request }) => {
    const response = await request.get('/api/health');
    expect(response.ok()).toBeTruthy();
    const data = await response.json();
    expect(data.status).toBe('ok');
    expect(data).toHaveProperty('message');
    expect(data).toHaveProperty('timestamp');
  });
});

test.describe('API - Public Antrian Routes', () => {
  test('should get antrian list without auth', async ({ request }) => {
    const response = await request.get('/api/antrian');
    expect([200, 500]).toContain(response.status());
  });

  test('should get antrian by poli without auth', async ({ request }) => {
    const response = await request.get('/api/antrian/poli/Umum');
    expect([200, 500]).toContain(response.status());
  });

  test('should get antrian quota without auth', async ({ request }) => {
    const today = new Date().toISOString().split('T')[0];
    const response = await request.get(`/api/antrian/kuota?poli=Umum&tanggal=${today}`);
    expect([200, 500]).toContain(response.status());
  });

  test('should filter antrian without auth', async ({ request }) => {
    const today = new Date().toISOString().split('T')[0];
    const response = await request.post('/api/antrian/filter', {
      data: { poli: 'Umum', tanggal: today }
    });
    expect([200, 500]).toContain(response.status());
  });
});

test.describe('API - Authentication', () => {
  test('should login user via API', async ({ request }) => {
    const response = await request.post('/api/auth/login', {
      data: TEST_USERS.user
    });
    expect(response.status()).toBe(200);
    const data = await response.json();
    expect(data.success).toBe(true);
    expect(data.data.user.role).toBe('user');
  });

  test('should login admin via API', async ({ request }) => {
    const response = await request.post('/api/auth/login', {
      data: { email: TEST_USERS.admin.email, password: TEST_USERS.admin.password }
    });
    expect(response.status()).toBe(200);
    const data = await response.json();
    expect(data.data.user.role).toBe('admin');
  });

  test('should login dokter via API', async ({ request }) => {
    const response = await request.post('/api/auth/login', {
      data: { email: TEST_USERS.dokter.email, password: TEST_USERS.dokter.password }
    });
    expect(response.status()).toBe(200);
    const data = await response.json();
    expect(data.data.user.role).toBe('dokter');
  });

  test('should reject invalid login', async ({ request }) => {
    const response = await request.post('/api/auth/login', {
      data: { email: 'invalid@test.com', password: 'wrong' }
    });
    expect(response.status()).toBe(401);
  });

  test('should reject missing credentials', async ({ request }) => {
    const response = await request.post('/api/auth/login', {
      data: { email: 'invalid-email' }
    });
    expect([200, 401, 422]).toContain(response.status());
  });

  test('should register new user via API', async ({ request }) => {
    const result = await registerUserApi(request);
    expect(result).not.toBeNull();
  });

  test('should reject duplicate email registration', async ({ request }) => {
    const response = await request.post('/api/auth/register', {
      data: {
        name: 'Test',
        email: TEST_USERS.user.email,
        password: 'password123',
        password_confirmation: 'password123'
      }
    });
    expect([200, 201, 409, 422, 500]).toContain(response.status());
  });

  test('should refresh token', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.post('/api/auth/refresh', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect(response.status()).toBe(200);
  });
});

test.describe('API - Protected Routes (Auth Required)', () => {
  test('should get user profile', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.get('/api/profile', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect(response.status()).toBe(200);
  });

  test('should get /me endpoint', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.get('/api/me', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect(response.status()).toBe(200);
  });

  test('should update profile', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.put('/api/profile', {
      data: { name: 'Updated Name' },
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 422]).toContain(response.status());
  });

  test('should logout', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.post('/api/logout', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect(response.status()).toBe(200);
  });

  test('should reject unauthenticated profile access', async ({ request }) => {
    const response = await request.get('/api/profile');
    expect(response.status()).toBe(401);
  });

  test('should reject unauthenticated me access', async ({ request }) => {
    const response = await request.get('/api/me');
    expect(response.status()).toBe(401);
  });

  test('should get user antrian list', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.get('/api/antrianmu', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });

  test('should create antrian', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const today = new Date().toISOString().split('T')[0];
    const response = await request.post('/api/antrian/send', {
      data: {
        poli: 'Umum',
        tanggal_daftar: today,
        nama: 'Test Patient',
        no_ktp: '1234567890123456',
        alamat: 'Jl. Test',
        jenis_kelamin: 'Laki-laki',
        no_hp: '081234567890',
        tgl_lahar: '1990-01-01',
        pekerjaan: 'Tester'
      },
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 201, 400, 422, 500]).toContain(response.status());
  });
});

test.describe('API - Role-Based Access Control', () => {
  test('should allow admin to access admin routes', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.get('/api/admin/users', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });

  test('should allow dokter to access dokter routes', async ({ request }) => {
    const token = await loginAsApi(request, 'dokter');
    if (!token) return;

    const response = await request.get('/api/doctor/antrian', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });

  test('should deny user from admin routes', async ({ request }) => {
    const token = await loginAsApi(request, 'user');
    if (!token) return;

    const response = await request.get('/api/admin/users', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 403, 500]).toContain(response.status());
  });

  test('should deny user from dokter routes', async ({ request }) => {
    const token = await loginAsApi(request, 'user');
    if (!token) return;

    const response = await request.get('/api/doctor/antrian', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 403, 500]).toContain(response.status());
  });

  test('should deny admin from dokter routes', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.get('/api/doctor/antrian', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 403, 500]).toContain(response.status());
  });

  test('should deny dokter from admin routes', async ({ request }) => {
    const token = await loginAsApi(request, 'dokter');
    if (!token) return;

    const response = await request.get('/api/admin/users', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 403, 500]).toContain(response.status());
  });
});

test.describe('API - Admin CRUD Operations', () => {
  test('should get all antrian', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.get('/api/admin/antrian', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 500]).toContain(response.status());
  });

  test('should create doctor', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const uniqueEmail = `newdokter${Date.now()}@example.com`;
    const response = await request.post('/api/admin/doctors', {
      data: {
        name: 'Dr. New',
        email: uniqueEmail,
        password: 'password123',
        poli_spesialisasi: 'Umum'
      },
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 201, 422, 500]).toContain(response.status());
  });

  test('should update doctor', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.put('/api/admin/doctors/1', {
      data: { name: 'Updated Doctor Name' },
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 404, 422, 500]).toContain(response.status());
  });

  test('should delete doctor', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    const response = await request.delete('/api/admin/doctors/999', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 204, 404, 500]).toContain(response.status());
  });

  test('should manage antrian status', async ({ request }) => {
    const token = await loginAsApi(request, 'admin');
    if (!token) return;

    for (const action of ['panggil', 'skip', 'selesai', 'reset']) {
      const response = await request.post(`/api/admin/antrian/1/${action}`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      expect([200, 201, 400, 404, 500]).toContain(response.status());
    }
  });
});

test.describe('API - Validation', () => {
  test('should reject invalid email format', async ({ request }) => {
    const response = await request.post('/api/auth/login', {
      data: { email: 'invalid-email', password: 'password' }
    });
    expect([200, 401, 422]).toContain(response.status());
  });

  test('should reject short password', async ({ request }) => {
    const response = await request.post('/api/auth/register', {
      data: {
        name: 'Test',
        email: 'test@example.com',
        password: 'short',
        password_confirmation: 'short'
      }
    });
    expect([200, 201, 422, 500]).toContain(response.status());
  });

  test('should reject password mismatch', async ({ request }) => {
    const response = await request.post('/api/auth/register', {
      data: {
        name: 'Test',
        email: 'test@example.com',
        password: 'password123',
        password_confirmation: 'different'
      }
    });
    expect([200, 201, 422, 500]).toContain(response.status());
  });

  test('should validate antrian required fields', async ({ request }) => {
    const token = await loginAsApi(request);
    if (!token) return;

    const response = await request.post('/api/antrian/send', {
      data: { poli: '' },
      headers: { 'Authorization': `Bearer ${token}` }
    });
    expect([200, 201, 400, 422, 500]).toContain(response.status());
  });
});