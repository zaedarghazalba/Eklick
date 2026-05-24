import { test as base } from '@playwright/test';
import { LoginPage } from './pages/LoginPage.ts';
import { AdminDashboardPage, DoctorDashboardPage, UserDashboardPage } from './pages/DashboardPage.ts';

export { LoginPage, AdminDashboardPage, DoctorDashboardPage, UserDashboardPage };

export const TEST_USERS = {
  admin: {
    email: 'admin@example.com',
    password: 'password',
    role: 'admin'
  },
  dokter: {
    email: 'dr.ahmad@klinik.com',
    password: 'password123',
    role: 'dokter'
  },
  user: {
    email: 'api@example.com',
    password: 'password123',
    role: 'user'
  }
};

export async function loginAs(page, role = 'user') {
  const user = TEST_USERS[role];
  const loginPage = new LoginPage(page);
  await loginPage.goto();
  await loginPage.login(user.email, user.password);
  return user;
}

export async function loginAsApi(request, role = 'user') {
  const user = TEST_USERS[role];
  const response = await request.post('/api/auth/login', {
    data: {
      email: user.email,
      password: user.password
    }
  });
  if (response.status() === 200) {
    const data = await response.json();
    return data.data.token;
  }
  return null;
}

export async function registerUserApi(request, email) {
  const uniqueEmail = email || `test${Date.now()}@example.com`;
  const response = await request.post('/api/auth/register', {
    data: {
      name: 'Test User',
      email: uniqueEmail,
      password: 'password123',
      password_confirmation: 'password123'
    }
  });
  if (response.status() === 201) {
    const data = await response.json();
    return { email: uniqueEmail, token: data.data.token };
  }
  return null;
}