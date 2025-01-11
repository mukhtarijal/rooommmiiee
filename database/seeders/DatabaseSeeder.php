<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Rule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed roles
        $this->seedRoles();

        // Seed users
        $this->seedUsers();

        // Seed cities
        $this->seedCities();

        // Seed rules
        $this->seedRules();

        // Seed facilities
        $this->seedFacilities();
    }

    /**
     * Seed roles into the database.
     */
    private function seedRoles(): void
    {
        Role::firstOrCreate(['name' => 'tenant']);
        Role::firstOrCreate(['name' => 'owner']);
        Role::firstOrCreate(['name' => 'admin']);
    }

    /**
     * Seed users into the database.
     */
    private function seedUsers(): void
    {
        // Pastikan role ada atau buat baru
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $tenantRole = Role::firstOrCreate(['name' => 'tenant']);

        // Membuat user jika tidak ada
        $this->createUser('Admin User', 'admin@example.com', 'password123', $adminRole);
        $this->createUser('Owner User', 'owner@example.com', 'password123', $ownerRole);
        $this->createUser('Tenant User', 'tenant@example.com', 'password123', $tenantRole);
    }

    /**
     * Create a user and assign a role.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param Role $role
     */
    private function createUser($name, $email, $password, $role)
    {
        $user = User::firstOrNew(['email' => $email]);
        if (!$user->exists) {
            $user->name = $name;
            $user->password = Hash::make($password);
            $user->save();
            $user->assignRole($role);
        }
    }

    /**
     * Seed cities into the database.
     */
    private function seedCities(): void
    {
        $cities = [
            // Kota-kota di Sumatera
            'Padang', 'Solok', 'Kabupaten Solok', 'Sawahlunto', 'Bukittinggi',
            'Pekanbaru', 'Medan', 'Palembang', 'Bandar Lampung', 'Jambi',
            'Bengkulu', 'Banda Aceh', 'Langsa', 'Lhokseumawe', 'Pematangsiantar',
            'Tanjungbalai', 'Binjai', 'Tebing Tinggi', 'Padang Sidempuan', 'Dumai',

            // Kota-kota di Jawa
            'Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang',
            'Malang', 'Depok', 'Tangerang', 'Bekasi', 'Bogor',
            'Surakarta', 'Cirebon', 'Tegal', 'Pekalongan', 'Magelang',
            'Madiun', 'Kediri', 'Blitar', 'Probolinggo', 'Pasuruan'
        ];

        foreach ($cities as $city) {
            City::firstOrCreate([
                'name' => $city,
                'slug' => Str::slug($city), // Generate slug dari nama kota
            ]);
        }
    }

    /**
     * Seed rules into the database.
     */
    private function seedRules(): void
    {
        $rules = [
            'Dilarang bawa hewan',
            'Dilarang merokok',
            'Tamu dilarang menginap',
            'Jam tenang 22:00 - 06:00',
            'Dilarang ubah struktur kamar',
            'Bayar sewa tepat waktu',
            'Jaga kebersihan kamar',
            'Dilarang pakai listrik berlebihan',
            'Lapor kerusakan fasilitas',
            'Dilarang tempel poster di dinding',
            'Dilarang bawa senjata',
            'Dilarang bawa kendaraan',
            'Patuhi jam malam',
            'Dilarang bawa tamu lawan jenis',
            'Pakai alas kaki di dalam',
            'Buang sampah pada tempatnya',
            'Dilarang pakai dapur berlebihan',
            'Jaga ketenangan',
            'Dilarang pinjam barang tanpa izin',
            'Patuhi aturan pengelola',
            'Dilarang masak di kamar',
            'Matikan AC saat keluar',
            'Dilarang taruh barang di lorong',
            'Lapor tamu yang berkunjung',
            'Hemat air dan listrik',
            'Jaga kerahasiaan kunci',
            'Dilarang bawa barang berharga',
            'Patuhi aturan fasilitas bersama',
            'Dilarang pindah perabotan',
            'Jaga privasi penghuni lain',
        ];

        foreach ($rules as $rule) {
            Rule::firstOrCreate([
                'rule' => $rule, // Mengisi kolom `rule`
            ]);
        }
    }

    /**
     * Seed facilities into the database.
     */
    private function seedFacilities(): void
    {
        $facilities = [
            'Kamar mandi dalam',
            'Kamar mandi luar',
            'AC',
            'Kipas angin',
            'Lemari',
            'Kasur',
            'Meja belajar',
            'Kursi',
            'Wi-Fi',
            'Dapur bersama',
            'Laundry',
            'Parkir motor',
            'Parkir mobil',
            'TV bersama',
            'Ruang tamu',
            'Ruang makan',
            'Listrik included',
            'Air included',
            'Satpam',
            'CCTV',
            'Mesin cuci',
            'Dispenser',
            'Ruang jemur',
            'Ruang ibadah',
            'Taman',
            'Lift',
            'Ruang gym',
            'Kolam renang',
            'Kantin',
            'Layanan kebersihan',
        ];

        foreach ($facilities as $facility) {
            Facility::firstOrCreate([
                'name' => $facility, // Mengisi kolom `name`
            ]);
        }
    }



}
