<?php

use Illuminate\Database\Seeder;

class ConfigurationTableSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $table = 'mst_configuration';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table($this->table)->truncate();

        $appDebug = config('app.debug') ? 'true' : 'false';
        $forceLocal = config('app.environment') !== 'production' ? 'true' : 'false';
        $sessionExpireOnClose = config('session.expire_on_close') ? 'true' : 'false';
        $sessionSecureCookie = config('session.secure_cookie') ? 'true' : 'false';
        $notifViaEmail = config('app.env') === 'local' ? 'false' : 'true';
        $bypassCutoff = config('app.env') === 'local' ? 'true' : 'false';

        $configurations = [
            ['key' => 'api_host', 'value' => 'http://10.6.226.199:3000/login', 'shortdesc' => 'Alamat IP untuk login UIM.', 'user_config' => 1, 'show_to_user' => 0, 'component' => 'auth', 'sequence' => 1],
            ['key' => 'auto_logout', 'value' => '10', 'shortdesc' => 'Auto logout user jika idle (dalam menit).', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'app', 'sequence' => 2],
            ['key' => 'backend_bo', 'value' => 'http://192.168.229.22:9191', 'shortdesc' => 'IP Backend BO.', 'user_config' => 1, 'show_to_user' => 0, 'component' => 'rdn', 'sequence' => 3],
            ['key' => 'bypass_cutoff', 'value' => $bypassCutoff, 'shortdesc' => 'By Pass Cut Off.', 'user_config' => 1, 'show_to_user' => 0, 'component' => 'parameter', 'sequence' => 4],
            ['key' => 'clientId', 'value' => 'AF3PNCQZ', 'shortdesc' => 'Sesuaikan dengan IP masing2', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'app', 'sequence' => 5],
            ['key' => 'clientSecret', 'value' => 'Fjx4C4AeV1iRL4_BWzwrrhSKtNaqSJ3IiGHTrHWYqRY', 'shortdesc' => 'Sesuaikan dengan IP masing2', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'app', 'sequence' => 6],
            ['key' => 'connection', 'value' => env('QUEUE_CONNECTION'), 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'queue', 'sequence' => 7],
            ['key' => 'connections', 'value' => str_ireplace(' ', '', '
                [
                    {
                        "name": "default",
                        "default": true,
                        "driver": "' . env('DB_CONNECTION') . '",
                        "host": "' . env('DB_HOST') . '",
                        "port": ' . env('DB_PORT') . ',
                        "database": "' . env('DB_DATABASE') . '",
                        "username": "' . env('DB_USERNAME') . '",
                        "password": "' . env('DB_PASSWORD') . '"
                    }
                ]'), 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'database', 'sequence' => 8],
            ['key' => 'copyright', 'value' => 'Copyright &copy; 2022. bank bjb.', 'shortdesc' => 'Hak Cipta aplikasi yang ditampilkan di footer.', 'user_config' => 1, 'show_to_user' => 0, 'component' => 'app', 'sequence' => 9],
            ['key' => 'debug', 'value' => $appDebug, 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'app', 'sequence' => 10],
            ['key' => 'default', 'value' => env('LOG_CHANNEL'), 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'logging', 'sequence' => 11],
            ['key' => 'disclaimer', 'value' => null, 'shortdesc' => 'Konten Disclaimer.', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'rdn', 'sequence' => 12],
            ['key' => 'display_name', 'value' => config('app.name'), 'shortdesc' => 'Nama aplikasi yang ditampilkan di setiap halaman.', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'app', 'sequence' => 13],
            ['key' => 'display_per_page', 'value' => '10', 'shortdesc' => 'Default data yang ditampilkan dalam tabel.', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'app', 'sequence' => 14],
            ['key' => 'domain', 'value' => request()->server('SERVER_NAME'), 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'session', 'sequence' => 15],
            ['key' => 'domain_hash_key', 'value' => null, 'shortdesc' => 'Hash Key untuk enkripsi otentikasi melalui UIM dari Domain Bank BJB.', 'user_config' => 1, 'show_to_user' => 0, 'component' => 'auth', 'sequence' => 16],
            ['key' => 'driver', 'value' => env('MAIL_DRIVER'), 'shortdesc' => 'Mail Driver', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'mail', 'sequence' => 17],
            ['key' => 'driver', 'value' => env('CACHE_DRIVER'), 'shortdesc' => 'Cache Driver', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'cache', 'sequence' => 18],
            ['key' => 'driver', 'value' => env('SESSION_DRIVER'), 'shortdesc' => 'Session Driver', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'session', 'sequence' => 19],
            ['key' => 'driver', 'value' => env('BROADCAST_DRIVER'), 'shortdesc' => 'Broadcast Driver', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'broadcasting', 'sequence' => 20],
            ['key' => 'encryption', 'value' => env('MAIL_ENCRYPTION'), 'shortdesc' => 'Mail Encrypt', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'mail', 'sequence' => 21],
            ['key' => 'env', 'value' => config('app.env'), 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'app', 'sequence' => 22],
            ['key' => 'expire_on_close', 'value' => $sessionExpireOnClose, 'shortdesc' => 'Session Expire Time', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'session', 'sequence' => 23],
            ['key' => 'force_local', 'value' => $forceLocal, 'shortdesc' => 'Login menggunakan local environment.', 'user_config' => 1, 'show_to_user' => 0, 'component' => 'auth', 'sequence' => 24],
            ['key' => 'from_address', 'value' => env('MAIL_FROM_ADDRESS'), 'shortdesc' => 'Alamat email pengirim.', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'mail', 'sequence' => 25],
            ['key' => 'from_name', 'value' => env('MAIL_FROM_NAME'), 'shortdesc' => 'Nama email pengirim.', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'mail', 'sequence' => 26],
            ['key' => 'ftp_bo', 'value' => '192.168.226.137', 'shortdesc' => 'IP FTP BO.', 'user_config' => 1, 'show_to_user' => 0, 'component' => 'rdn', 'sequence' => 27],
            ['key' => 'hash_key', 'value' => null, 'shortdesc' => 'Hash Key untuk enkripsi otentikasi melalui UIM.', 'user_config' => 1, 'show_to_user' => 0, 'component' => 'auth', 'sequence' => 28],
            ['key' => 'host', 'value' => env('MAIL_HOST'), 'shortdesc' => 'Mail Host', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'mail', 'sequence' => 29],
            ['key' => 'https', 'value' => 'false', 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'app', 'sequence' => 30],
            ['key' => 'id', 'value' => null, 'shortdesc' => 'ID Aplikasi yang di daftarkan di UIM', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'auth', 'sequence' => 31],
            ['key' => 'lifetime', 'value' => env('SESSION_LIFETIME'), 'shortdesc' => 'Session Lifetime', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'session', 'sequence' => 32],
            ['key' => 'logo', 'value' => 'logo.png', 'shortdesc' => 'Logo aplikasi.', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'app', 'sequence' => 33],
            ['key' => 'method', 'value' => 'local', 'shortdesc' => 'Metode Login yang digunakan.', 'user_config' => 1, 'show_to_user' => 0, 'component' => 'auth', 'sequence' => 34],
            ['key' => 'motd', 'value' => 'Selamat datang di Aplikasi bjbBackOffice', 'shortdesc' => 'Message of The Day untuk ditampilkan di Halaman Home.', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'rdn', 'sequence' => 35],
            ['key' => 'name', 'value' => config('app.name'), 'shortdesc' => 'Nama aplikasi.', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'app', 'sequence' => 36],
            ['key' => 'notif_via_email', 'value' => $notifViaEmail, 'shortdesc' => 'Kirim notifikasi melalui email.', 'user_config' => 1, 'show_to_user' => 1, 'component' => 'parameter', 'sequence' => 37],
            ['key' => 'password', 'value' => env('MAIL_PASSWORD'), 'shortdesc' => 'Mail Password', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'mail', 'sequence' => 38],
            ['key' => 'port', 'value' => env('MAIL_PORT'), 'shortdesc' => 'Mail Port', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'mail', 'sequence' => 39],
            ['key' => 'secret_key', 'value' => \Illuminate\Support\Str::random(32), 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'app', 'sequence' => 40],
            ['key' => 'secure_cookie', 'value' => $sessionSecureCookie, 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'session', 'sequence' => 41],
            ['key' => 'url', 'value' => request()->getSchemeAndHttpHost(), 'shortdesc' => 'URL Aplikasi', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'app', 'sequence' => 42],
            ['key' => 'username', 'value' => env('MAIL_USERNAME'), 'shortdesc' => 'Mail Username', 'user_config' => 0, 'show_to_user' => 0, 'component' => 'mail', 'sequence' => 43],
            ['key' => 'wkhtmltopdf', 'value' => (config('app.env') === 'local' ? '"D:\Server\wkhtmltopdf\bin\wkhtmltopdf.exe"' : '/usr/local/bin/wkhtmltopdf'), 'shortdesc' => null, 'user_config' => 0, 'show_to_user' => 0, 'component' => 'misc', 'sequence' => 44],
        ];

        \Illuminate\Support\Facades\DB::table($this->table)->insert($configurations);
    }
}
