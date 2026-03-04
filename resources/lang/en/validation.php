<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi
    |--------------------------------------------------------------------------
    */

    'accepted' => 'Kolom :attribute harus diterima.',
    'active_url' => 'Kolom :attribute bukan URL yang valid.',
    'after' => 'Kolom :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Kolom :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Kolom :attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Kolom :attribute harus berupa sebuah array.',
    'before' => 'Kolom :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Kolom :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => 'Kolom :attribute harus bernilai antara :min sampai :max.',
        'file' => 'Ukuran :attribute harus antara :min sampai :max kilobita.',
        'string' => 'Kolom :attribute harus berisi antara :min sampai :max karakter.',
        'array' => 'Kolom :attribute harus memiliki :min sampai :max item.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai true atau false.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => 'Kolom :attribute bukan tanggal yang valid.',
    'date_equals' => 'Kolom :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Kolom :attribute tidak cocok dengan format :format.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus terdiri dari :digits angka.',
    'digits_between' => 'Kolom :attribute harus terdiri dari :min sampai :max angka.',
    'dimensions' => 'Ukuran gambar :attribute tidak valid.',
    'distinct' => 'Kolom :attribute memiliki nilai yang duplikat.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'regex' => 'Format :attribute tidak valid. Pastikan menggunakan domain yang benar (misal: .com atau .id).',
    'ends_with' => 'Kolom :attribute harus diakhiri dengan salah satu dari: :values.',
    'exists' => 'Pilihan :attribute tidak valid.',
    'file' => 'Kolom :attribute harus berupa sebuah file.',
    'filled' => 'Kolom :attribute wajib diisi.',
    'gt' => [
        'numeric' => 'Kolom :attribute harus lebih besar dari :value.',
        'file' => 'Ukuran :attribute harus lebih besar dari :value kilobita.',
        'string' => 'Kolom :attribute harus lebih dari :value karakter.',
        'array' => 'Kolom :attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric' => 'Kolom :attribute harus lebih besar dari atau sama dengan :value.',
        'file' => 'Ukuran :attribute harus lebih besar dari atau sama dengan :value kilobita.',
        'string' => 'Kolom :attribute harus minimal :value karakter.',
        'array' => 'Kolom :attribute harus memiliki :value item atau lebih.',
    ],
    'image' => 'Kolom :attribute harus berupa gambar.',
    'in' => 'Pilihan :attribute tidak valid.',
    'in_array' => 'Kolom :attribute tidak ada di :other.',
    'integer' => 'Kolom :attribute harus berupa bilangan bulat.',
    'ip' => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Kolom :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Kolom :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Kolom :attribute harus berupa string JSON yang valid.',
    'lt' => [
        'numeric' => 'Kolom :attribute harus kurang dari :value.',
        'file' => 'Ukuran :attribute harus kurang dari :value kilobita.',
        'string' => 'Kolom :attribute harus kurang dari :value karakter.',
        'array' => 'Kolom :attribute harus memiliki kurang dari :value item.',
    ],
    'lte' => [
        'numeric' => 'Kolom :attribute harus kurang dari atau sama dengan :value.',
        'file' => 'Ukuran :attribute harus kurang dari atau sama dengan :value kilobita.',
        'string' => 'Kolom :attribute harus maksimal :value karakter.',
        'array' => 'Kolom :attribute tidak boleh memiliki lebih dari :value item.',
    ],
    'max' => [
        'numeric' => 'Kolom :attribute tidak boleh lebih besar dari :max.',
        'file' => 'Ukuran :attribute tidak boleh lebih besar dari :max kilobita.',
        'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
        'array' => 'Kolom :attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'mimes' => 'Kolom :attribute harus berupa file bertipe: :values.',
    'mimetypes' => 'Kolom :attribute harus berupa file bertipe: :values.',
    'min' => [
        'numeric' => 'Kolom :attribute harus minimal :min.',
        'file' => 'Ukuran :attribute harus minimal :min kilobita.',
        'string' => 'Kolom :attribute harus minimal :min karakter.',
        'array' => 'Kolom :attribute harus memiliki minimal :min item.',
    ],
    'not_in' => 'Pilihan :attribute tidak valid.',
    'not_regex' => 'Format :attribute tidak valid.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'password' => 'Kata sandi salah.',
    'present' => 'Kolom :attribute wajib ada.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => 'Kolom :attribute wajib diisi.',
    'required_if' => 'Kolom :attribute wajib diisi bila :other adalah :value.',
    'required_unless' => 'Kolom :attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with' => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_with_all' => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_without' => 'Kolom :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Kolom :attribute wajib diisi bila tidak ada satupun :values.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'size' => [
        'numeric' => 'Kolom :attribute harus berukuran :size.',
        'file' => 'Ukuran :attribute harus berukuran :size kilobita.',
        'string' => 'Kolom :attribute harus berukuran :size karakter.',
        'array' => 'Kolom :attribute harus mengandung :size item.',
    ],
    'starts_with' => 'Kolom :attribute harus diawali dengan salah satu dari: :values.',
    'string' => 'Kolom :attribute harus berupa string.',
    'timezone' => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Data :attribute sudah terdaftar di sistem.',
    'uploaded' => 'Gagal mengunggah :attribute.',
    'url' => 'Format :attribute tidak valid.',
    'uuid' => 'Kolom :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Kustomisasi Nama Atribut
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'nama' => 'Nama Lengkap',
        'email' => 'Alamat Email',
        'nomor_whatsapp' => 'Nomor WhatsApp',
        'password' => 'Password',
        'password_confirmation' => 'Konfirmasi Password',
        'path_cv' => 'File CV',
    ],

];