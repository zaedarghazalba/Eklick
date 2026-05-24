<?php

namespace App\Helpers;

class MenuHelper
{
    /**
     * Get user navigation menu items
     *
     * @return array
     */
    public static function getUserMenu(): array
    {
        return [
            [
                'label' => 'Home',
                'url' => '#hero',
                'class' => 'scrollto',
                'active' => true
            ],
            [
                'label' => 'Antrian',
                'url' => '/antrianmu',
                'class' => 'scrollto',
                'active' => false
            ],
            [
                'label' => 'About',
                'url' => '#about',
                'class' => 'scrollto',
                'active' => false
            ],
            [
                'label' => 'Contact',
                'url' => '#contact',
                'class' => 'scrollto',
                'active' => false
            ],
        ];
    }

    /**
     * Get admin sidebar menu items
     *
     * @return array
     */
    public static function getAdminMenu(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'url' => 'admin.dashboard',
                'icon' => 'bi bi-grid',
                'active' => true
            ],
            [
                'label' => 'Kelola User',
                'url' => 'admin.users',
                'icon' => 'bi bi-people',
                'active' => false
            ],
            [
                'label' => 'Kelola Dokter',
                'url' => 'admin.doctors',
                'icon' => 'bi bi-person-badge',
                'active' => false
            ],
            [
                'label' => 'Data Pasien',
                'url' => 'admin.data-pasien',
                'icon' => 'bi bi-clipboard-data',
                'active' => false
            ],
            [
                'label' => 'Arsip Data Pasien',
                'url' => 'admin.data-pasien.archive',
                'icon' => 'bi bi-archive',
                'active' => false
            ],
            [
                'label' => 'Kelola Antrian',
                'url' => 'admin.antrian',
                'icon' => 'bi bi-list-check',
                'active' => false
            ],
        ];
    }

    /**
     * Get doctor sidebar menu items
     *
     * @param string $poli
     * @return array
     */
    public static function getDoctorMenu(string $poli = 'Umum'): array
    {
        return [
            [
                'label' => 'Dashboard',
                'url' => 'dashboardoc',
                'icon' => 'bi bi-grid',
                'active' => true,
                'badge' => null
            ],
            [
                'label' => 'Antrian ' . $poli,
                'url' => 'dashboardoc',
                'icon' => 'bi bi-list-check',
                'active' => false,
                'badge' => null
            ],
        ];
    }

    /**
     * Get top bar contact information
     *
     * @return array
     */
    public static function getTopBarInfo(): array
    {
        return [
            'email' => 'contact@eklick.com',
            'phone' => '+62 123 4567 890',
            'social' => [
                [
                    'name' => 'twitter',
                    'url' => '#',
                    'icon' => 'bi bi-twitter'
                ],
                [
                    'name' => 'facebook',
                    'url' => '#',
                    'icon' => 'bi bi-facebook'
                ],
                [
                    'name' => 'instagram',
                    'url' => '#',
                    'icon' => 'bi bi-instagram'
                ],
                [
                    'name' => 'linkedin',
                    'url' => '#',
                    'icon' => 'bi bi-linkedin'
                ],
            ]
        ];
    }
}
