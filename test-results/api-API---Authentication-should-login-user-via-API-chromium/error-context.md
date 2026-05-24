# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: api.spec.js >> API - Authentication >> should login user via API
- Location: tests\e2e\api.spec.js:42:3

# Error details

```
Error: expect(received).toBe(expected) // Object.is equality

Expected: 200
Received: 401
```

# Test source

```ts
  1   | import { test, expect } from '@playwright/test';
  2   | import { TEST_USERS, loginAsApi, registerUserApi } from './helpers.js';
  3   | 
  4   | test.describe('API - Health Check', () => {
  5   |   test('should return health check status', async ({ request }) => {
  6   |     const response = await request.get('/api/health');
  7   |     expect(response.ok()).toBeTruthy();
  8   |     const data = await response.json();
  9   |     expect(data.status).toBe('ok');
  10  |     expect(data).toHaveProperty('message');
  11  |     expect(data).toHaveProperty('timestamp');
  12  |   });
  13  | });
  14  | 
  15  | test.describe('API - Public Antrian Routes', () => {
  16  |   test('should get antrian list without auth', async ({ request }) => {
  17  |     const response = await request.get('/api/antrian');
  18  |     expect([200, 500]).toContain(response.status());
  19  |   });
  20  | 
  21  |   test('should get antrian by poli without auth', async ({ request }) => {
  22  |     const response = await request.get('/api/antrian/poli/Umum');
  23  |     expect([200, 500]).toContain(response.status());
  24  |   });
  25  | 
  26  |   test('should get antrian quota without auth', async ({ request }) => {
  27  |     const today = new Date().toISOString().split('T')[0];
  28  |     const response = await request.get(`/api/antrian/kuota?poli=Umum&tanggal=${today}`);
  29  |     expect([200, 500]).toContain(response.status());
  30  |   });
  31  | 
  32  |   test('should filter antrian without auth', async ({ request }) => {
  33  |     const today = new Date().toISOString().split('T')[0];
  34  |     const response = await request.post('/api/antrian/filter', {
  35  |       data: { poli: 'Umum', tanggal: today }
  36  |     });
  37  |     expect([200, 500]).toContain(response.status());
  38  |   });
  39  | });
  40  | 
  41  | test.describe('API - Authentication', () => {
  42  |   test('should login user via API', async ({ request }) => {
  43  |     const response = await request.post('/api/auth/login', {
  44  |       data: TEST_USERS.user
  45  |     });
> 46  |     expect(response.status()).toBe(200);
      |                               ^ Error: expect(received).toBe(expected) // Object.is equality
  47  |     const data = await response.json();
  48  |     expect(data.success).toBe(true);
  49  |     expect(data.data.user.role).toBe('user');
  50  |   });
  51  | 
  52  |   test('should login admin via API', async ({ request }) => {
  53  |     const response = await request.post('/api/auth/login', {
  54  |       data: { email: TEST_USERS.admin.email, password: TEST_USERS.admin.password }
  55  |     });
  56  |     expect(response.status()).toBe(200);
  57  |     const data = await response.json();
  58  |     expect(data.data.user.role).toBe('admin');
  59  |   });
  60  | 
  61  |   test('should login dokter via API', async ({ request }) => {
  62  |     const response = await request.post('/api/auth/login', {
  63  |       data: { email: TEST_USERS.dokter.email, password: TEST_USERS.dokter.password }
  64  |     });
  65  |     expect(response.status()).toBe(200);
  66  |     const data = await response.json();
  67  |     expect(data.data.user.role).toBe('dokter');
  68  |   });
  69  | 
  70  |   test('should reject invalid login', async ({ request }) => {
  71  |     const response = await request.post('/api/auth/login', {
  72  |       data: { email: 'invalid@test.com', password: 'wrong' }
  73  |     });
  74  |     expect(response.status()).toBe(401);
  75  |   });
  76  | 
  77  |   test('should reject missing credentials', async ({ request }) => {
  78  |     const response = await request.post('/api/auth/login', {
  79  |       data: { email: 'invalid-email' }
  80  |     });
  81  |     expect([200, 401, 422]).toContain(response.status());
  82  |   });
  83  | 
  84  |   test('should register new user via API', async ({ request }) => {
  85  |     const result = await registerUserApi(request);
  86  |     expect(result).not.toBeNull();
  87  |   });
  88  | 
  89  |   test('should reject duplicate email registration', async ({ request }) => {
  90  |     const response = await request.post('/api/auth/register', {
  91  |       data: {
  92  |         name: 'Test',
  93  |         email: TEST_USERS.user.email,
  94  |         password: 'password123',
  95  |         password_confirmation: 'password123'
  96  |       }
  97  |     });
  98  |     expect([200, 201, 409, 422, 500]).toContain(response.status());
  99  |   });
  100 | 
  101 |   test('should refresh token', async ({ request }) => {
  102 |     const token = await loginAsApi(request);
  103 |     if (!token) return;
  104 | 
  105 |     const response = await request.post('/api/auth/refresh', {
  106 |       headers: { 'Authorization': `Bearer ${token}` }
  107 |     });
  108 |     expect(response.status()).toBe(200);
  109 |   });
  110 | });
  111 | 
  112 | test.describe('API - Protected Routes (Auth Required)', () => {
  113 |   test('should get user profile', async ({ request }) => {
  114 |     const token = await loginAsApi(request);
  115 |     if (!token) return;
  116 | 
  117 |     const response = await request.get('/api/profile', {
  118 |       headers: { 'Authorization': `Bearer ${token}` }
  119 |     });
  120 |     expect(response.status()).toBe(200);
  121 |   });
  122 | 
  123 |   test('should get /me endpoint', async ({ request }) => {
  124 |     const token = await loginAsApi(request);
  125 |     if (!token) return;
  126 | 
  127 |     const response = await request.get('/api/me', {
  128 |       headers: { 'Authorization': `Bearer ${token}` }
  129 |     });
  130 |     expect(response.status()).toBe(200);
  131 |   });
  132 | 
  133 |   test('should update profile', async ({ request }) => {
  134 |     const token = await loginAsApi(request);
  135 |     if (!token) return;
  136 | 
  137 |     const response = await request.put('/api/profile', {
  138 |       data: { name: 'Updated Name' },
  139 |       headers: { 'Authorization': `Bearer ${token}` }
  140 |     });
  141 |     expect([200, 422]).toContain(response.status());
  142 |   });
  143 | 
  144 |   test('should logout', async ({ request }) => {
  145 |     const token = await loginAsApi(request);
  146 |     if (!token) return;
```