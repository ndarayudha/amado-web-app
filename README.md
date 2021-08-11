# Manajemen Pasien Gejala Hipoksia Terintegrasi Berbasis Web





<p align="center">
  <br>
  <img src="https://i.ibb.co/ssb5mKk/amado.png">
  <br>
  <b style="font-size:25px; ">Amado Web App</b>
  <br>
  <br>
  <img src="https://img.shields.io/github/v/release/yofan2408/amado-web-app?style=for-the-badge">
  <img src="https://img.shields.io/badge/PHP-7.4.4-blue?style=for-the-badge">
  <img src="https://img.shields.io/badge/LARAVEL-8-blue?style=for-the-badge">
  <img src="https://img.shields.io/github/contributors/yofan2408/amado-web-app?color=blue&style=for-the-badge">
  <img src="https://img.shields.io/github/last-commit/yofan2408/amado-web-app?style=for-the-badge">
</p>




## Tentang

Aplikasi Web ini ditujukan kepada pihak instansi kesehatan untuk mempermudah pengelolaan pasien gejala Hipoksia yang sering diderita oleh pasien Covid-19 saat ini. Fitur yang ditawarkan pada aplikasi web ini adalah pengelolaan data pasien, mengetahui lokasi pasien yang melakukan monitoring, data rekam medis pasien, dan daftar kontak erat yang dimiliki oleh pasien yang diisi melalui aplikasi android yang terintegrasi dengan aplikasi web ini.

## Integrasi Android

Aplikasi web ini terintegrasi dengan aplikasi android yang digunakan oleh pasien. Pasien melakukan proses pendaftaran akun dan pengisian identitas diri sebelum dapat melakukan monitoring. Fitur dari aplikasi ini adalah memantau hasil monitoring, mengetahui lokasi pasien, mengetahui hasil diagnosa berdasarkan monitoring, rekomendasi penanganan lanjut dari dokter, dan melakukan pengisian form kontak erat jika pasien mengalami gejala Hipoksia. Aplikasi android ini selain terintegrasi dengan web, juga terintegrasi dengan perangkat Hardware untuk mengambil data parameter yang terkait dengan gejala Hipoksia.

## Integrasi Hardware

Hardware yang terintegrasi ini bertugas untuk mendapatkan data saturasi oksigen dalam darah (Spo2) dan denyut jantung per menit (Bpm). Hardware ini berbasiskan mikrokontroler ESP8266 yang mengirimkan data Spo2 dan Bpm ke platform web (Thingspeak). Data kemudian akan diakses oleh aplikasi android saat pasien melakukan monitoing dan disimpan ke website Hipoksia. Proses pemantauan pasien dilakukan sebanyak 3 kali sekali dalam 24 jam selama 10 - 15 detik untuk sekali monitoring.

# Cara Install

```bash
1. buka git bash
2. git clone https://github.com/yofan2408/manajemen_pasien_gejala_hipoksia.git
3. cd manajemen_pasien_gejala_hipoksia
4. composer install
5. npm install
6. npm run dev
7. buat database di php my admin
8. ubah nama file .env.example menjadi .env
9. php artisan key:generate
10. setup database .env
11. php artisan migrate --seed
12. php artisan passport:install
13. php artisan schedule:work
14. php artisan serv
```

# API Android

-   [Autentikasi](#autentikasi)
    -   [Login](#login)
        -   [Pasien](#l_pasien)
    -   [Register](#register)
        -   [Pasien](#r_pasien)
    -   [Logout](#logout)
        -   [Pasien](#lg_pasien)
    -   [Update](#update)
        -   [Pasien](#up_pasien)
    -   [Upload Photo](#photo)
        -   [Pasien](#ph_pasien)
    -   [Get Photo](#get_photo)
        -   [Pasien](#get_ph_pasien)
    -   [Get Pasien](#get_biodata)
        -   [Pasien](#get_patient)
-   [Reset Password](#reset_passowrd)
    -   [Forgot](#forgot)
        -   [Pasien](#forgot_pasien)
    -   [Reset](#reset)
        -   [Pasien](#reset_pasien)
-   [Notification](#notification)
    -   [Topic](#notification_topic)
        -   [Update Topic](#n_topic_update)
        -   [Delete Topic](#n_topic_delete)
        -   [Get Topic](#n_topic_get)
    -   [Token](#notification_token)
        -   [Update token](#n_token_update)
        -   [Delete token](#n_token_delete)
        -   [Get token](#n_token_get)
-   [Device](#device)
    -   [Create Hardware Identifier](#d_hardware)
        -   [Pasien](#dh_pasien)
    -   [Mobile Identifier](#d_mobile)
        -   [Pasien](#dm_pasien)
    -   [Enable/Disable Device](#en_device)
        -   [Pasien](#en_pasien)
    -   [Get Serial Number](#en_device_serial)
        -   [Pasien](#en_serial)
-   [Kontak Erat](#kontak_erat)
    -   [Isi form kontak erat](#kontak_form)
        -   [Insert](#kontak_erat_insert)
-   [Geolokasi](#geolokasi)
    -   [Update Patient Location](#patient_location)
        -   [Update](#p_location_update)
    -   [Get All Patient Location](#all_patient_location)
        -   [Get](#all_location_update)
-   [Monitoring](#m_monitoring)
    -   [Get Monitoring Result](#monitoring_result)
-   [Rekam Medis](#rekam_medis)
    -   [Rekam Medis Pasien](#patient_record)
        -   [Get](#patient_record_get)
        -   [Delete](#patient_record_delete)


# API Hardware
-   [Pulse Oximetry](#pulse)
    -   [Insert Spo2 & Bpm](#pulse_insert)
        -   [Pasien](#sen_patient)
    -   [Get Data Sensor](#pulse_get)
        -   [Pasien](#pulse_data)

<!-- ============= AUTHENTICATION START ============= -->
# <a name="autentikasi"></a>Autentikasi

<!-- ============= LOGIN START ============= -->
## <a name="login"></a>Login
#### <a name="l_pasien"></a>Login Pasien

Request :

-   Method : POST
-   Endpoint : 'patient/v1/login'
-   Header :
    -   Content-Type : application/json
-   Body

```json
{
    "email": "example@gmail.com",
    "password": "example_password"
}
```

Response :

-   Success

```json
{
    "code": 200,
    "status": "berhasil",
    "Topic_type": "Bearer",
    "access_token": "example_token",
    "token_id": "example_token_id",
    "user": {
        "id": "user_id",
        "name": "example_name",
        "email": "example_name@gmail.com",
        "created_at": "2021-02-17T16:16:36.000000Z",
        "updated_at": "2021-02-17T16:16:36.000000Z"
    }
}
```

-   Error

```json
{
    "code": 400,
    "status": "gagal",
    "message": "pesan gagal"
}
```
<!-- ============= LOGIN END ============= -->




<!-- ============= REGISTER START ============= -->
## <a name="register"></a>Register
#### <a name="r_pasien"></a>Register Pasien

Request :

-   Method : POST
-   Endpoint : 'patient/v1/register'
-   Header :
    -   Content-Type : application/json
-   Body

```json
{
    "name": "example name",
    "email": "example@gmail.com",
    "password": "example_password",
    "password_confirmation": "example_password"
}
```

Response :

-   Success

```json
{
    "code": 201,
    "status": "berhasil",
    "token_type": "Bearer",
    "access_token": "example_token",
    "token_id": "example_token_id",
    "user": {
        "id": "user_id",
        "name": "example_name",
        "email": "example_name@gmail.com",
        "created_at": "2021-02-17T16:16:36.000000Z",
        "updated_at": "2021-02-17T16:16:36.000000Z"
    }
}
```

-   Error

```json
{
    "code": 400,
    "status": "gagal",
    "message": "pesan gagal"
}
```
<!-- ============= REGISTER END ============= -->



<!-- ============= LOGOUT START ============= -->
## <a name="logout"></a>Logout
#### <a name="lg_pasien"></a>Logout Pasien

Request :

-   Method : POST
-   Endpoint : 'patient/v1/logout'
-   Header :
    -   Content-Type : application/json
-   Body

```json
{
    "token_id": "example_token_id"
}
```

Response :

-   Success

```json
{
    "code": 200,
    "status": "berhasil",
    "message": "pesan logout"
}
```

-   Error

```json
{
    "code": 400,
    "status": "gagal",
    "message": "pesan logout"
}
```
<!-- ============= LOGOUT END ============= -->



<!-- ============= UPDATE START ============= -->
## <a name="update"></a>Update
#### <a name="up_pasien"></a>Update Pasien

Request :

-   Method : POST
-   Endpoint : 'patient/update'
-   Header :
    -   Content-Type : application/json
    -   Authorization : Bearer
-   Body

```json
{
    "nama": "nama_pasien",
    "jenis_kelamin": "jenis_kelamin_pasien",
    "nik": "nik pasien",
    "alamat": "alamat_pasien",
    "tanggal_lahir": "tanggal_lahir_pasien",
    "phone": "nomor_telepon_pasien"
}
```

Response :

-   Success

```json
{
    "code": 200,
    "status": "berhasil",
    "message": "data pasien telah di update",
    "user": {
        "id": 1,
        "name": "nama_paisen",
        "email": "email_pasien",
        "nik" : "nik pasien",
        "jenis_kelamin": "jenis_kelamin_pasien",
        "alamat": "alamat_pasien",
        "tangggal_lahir": "tanggal_lahir_pasien",
        "phone": "nomor_telepon_pasien",
        "created_at": "2021-02-18T07:44:04.000000Z",
        "updated_at": "2021-02-18T07:45:46.000000Z"
    }
}
```

-   Error

```json
{
    "code": 400,
    "status": "gagal",
    "message": "pesan update"
}
```
<!-- ============= UPDATE END ============= -->



<!-- ============= UPDATE PHOTO START ============= -->
## <a name="photo"></a>Update Photo
#### <a name="ph_pasien"></a>Upload Photo Pasien

Request :

-   Method : POST
-   Endpoint : 'patient/add-profile-photo'
-   Header :
    -   Content-Type : application/json
    -   Authorization : Bearer
-   Body

```json
{
    "photo": "base64 format"
}
```

Response :

-   Success

```json
{
    "code": 200,
    "status": "berhasil",
    "message": "pesan berhasil",
    "user": {
        "id": 1,
        "name": "nama_pasien",
        "photo": "namafoto.jpg",
        "created_at": "2021-02-18T05:30:33.000000Z",
        "updated_at": "2021-02-19T04:09:55.000000Z"
    }
}
```

-   Error

```json
{
    "code": 400,
    "status": "gagal",
    "message": "pesan error upload foto"
}
```

## <a name="get_photo"></a>Get Photo

#### <a name="get_ph_pasien"></a>Pasien

Request :

-   Method : POST
-   Endpoint : 'patient/user-profile'
-   Header :
    -   Content-Type : application/json
    -   Authorization : Bearer

Response :

-   Success :

```json
{
    "code": 200,
    "status": "berhasil",
    "message": "data:image/png;base64,random_string_base64"
}
```

-   Error :

```json
{
    "code": 400,
    "status": "gagal",
    "message": "gambar gagal diupload"
}
```
<!-- ============= UPDATE PHOTO END ============= -->



<!-- ============= GET PATIENT START ============= -->
## <a name="get_biodata"></a>Get Biodata
#### <a name="biodata_pasien"></a>Pasien
Request :
-   Method: GET
-   Endpoint : 'patient/bio'
-   Header :
    -   Content-Type : application/json
    -   Authorization : bearer
-   Body:

Patient ID
```json
{
    "id" : 1
}
```
Response: 
-   Success:
```json
{
    "code": 200,
    "status": "berhasil",
    "message": "data pasien berhasil ditamabahkan",
    "user": {
        "id": 1,
        "name": "nama_paisen",
        "email": "email_pasien",
        "nik": "nik pasien",
        "jenis_kelamin": "jenis_kelamin_pasien",
        "alamat": "alamat_pasien",
        "tangggal_lahir": "tanggal_lahir_pasien",
        "phone": "nomor_telepon_pasien"
    }
}
```

-   Failed:
```json
{
    "code": 400,
    "status": "gagal",
    "mesage": "pasien belum terdaftar"
}
```
<!-- ============= GET PATIENT END ============= -->
<!-- ============= AUTHENTICATION END ============= -->




<!-- ============= PASSWORD START ============= -->
# <a name="reset_password"></a>Reset Password

<!-- ============= FORGOT PASSWORD START ============= -->
## <a name="forgot"></a>Forgot
#### <a name="forgot_pasien"></a>Forgot Password Pasien

Request :

-   Method : POST
-   Endpoint : 'patient/v1/forgot-password'
-   Header :
    -   Content-Type : application/json
-   Body:

```json
{
    "email": "patient@gmail.com"
}
```

Response :

-   Success

```json
{
    "code": 200,
    "status": "berhasil",
    "token": "reset password token"
}
```

-   Failed

```json
{
    "code": 400,
    "status": "gagal",
    "message": "error message"
}
```
<!-- ============= FORGOT PASSWORD END ============= -->



<!-- ============= RESET PASSWORD START ============= -->
## <a name="reset"></a>Reset
#### <a name="reset_pasien"></a>Reset Password Pasien

-   Method : POST
-   Endpoint : 'patient/v1/reset-password'
-   Header :
    -   Content-Type : application/json
-   Body:

```json
{
    "password": "new password",
    "password_confirmation": "confirmation password",
    "token": "reset password token"
}
```

Response :

-   Success :

```json
{
    "code": 200,
    "status": "success",
    "message": "password reset successful"
}
```

-   Failed:

```json
{
    "code": 400,
    "status": "failed",
    "message": "check your param or invalid token"
}
```
<!-- ============= RESET PASSWORD END ============= -->
<!-- ============= PASSWORD END ============= -->





<!-- ============= KONTAK ERAT START ============== -->
# <a name="kontak_erat"></a>Kontak Erat
## <a name="kontak_form"></a>Isi Form Kontak Erat
### <a name="kontak_erat_insert"></a>Insert
Request:
-   Method: POST
-   Endpoint: 'patient/kontak/insert'
-   Header:
    -   Authorization: Bearer
    -   Content-Type: application/json
-   Body:
```json
{
    "address": "alamat lokasi",
    "name": "nama orang (jika dikenal)",
    "relationship": "hubungan (teman, saudara, dll)",
    "duration": "pekiraan durasi (menit / jam)",
    "time": "jam waktu kontak erat terjadi",
    "date": "tanggal waktu kontak erat terjadi",
    "latitude": "latitude",
    "longitude": "longitude"
}
```

Response:
-   Success:
```json
{
    "code": 200,
    "status": "berhasil",
    "message": "kontak erat berhasil disimpan"
}
```
-   Failed:
```json
{
    "code": 400,
    "status": "gagal",
    "message": "kontak erat gagal disimpan"
}
```
<!-- ============= KONTAK ERAT END ============== -->

        
<!-- ============= NOTIFICATION START =============== -->
# <a name="notification"></a>Notifikasi

<!-- ============= TOPIC NOTIFICATION START -->
## <a name="notification_topic"></a>Topic Notification
#### <a name="n_topic_update"></a>Update Topic
Request :
-   Method : POST
-   Endpoint : 'patient/topic/update'
-   Header :
    -   Authorization: Bearer
    -   Content-Type: application/json
-   Body:
#### Value = ID Topic
```json
{
    "topic": 2
}
```

Response:
-   Success:
```json
{
    "code": 200,
    "status": "berhasil",
    "message": "topic berhasil diupdate"
}
```

-   Failed:
```json
{
    "code": 400,
    "status": "gagal",
    "message": "topic gagal diupdate"
}
```

#### <a name="n_topic_delete"></a>Delete Topic
Request:
-   Method: POST
-   Endpoint: 'patient/topic/delete'
-   Header:
    -   Authorizaton: Bearer
    -   Content-Type: application/json
-   Body:
#### Value = ID Topic
```json
{
    "topic": 2
}
```

Response:
-   Success:
```json
{
    "code": 200,
    "status": "berhasil",
    "message": "topic berhasil dihapus"
}
```
-   Failed:
```json
{
    "code": 400,
    "status": "gagal",
    "message": "topic gagal dihapus"
}
```

#### <a name="n_topic_get"></a>Get All Topics
Request:
-   Method: POST
-   Endpoint: 'patient/topic/topics'
-   Header:
    -   Authorizaton: Bearer
    -   Content-Type: application/json

Response:
-   Success:
```json
{
    "code": 200,
    "status": "berhasil",
    "topics": [
        {
            "id": 1,
            "device_id": 1,
            "notification_topic_id": 1,
            "title": "Waktunya Monitoring",
            "description": "Saatnya melakukan monitoring kadar saturasi anda, lakukan dengan durasi 1 menit",
            "image": "",
            "created_at": "2021-06-07T07:27:14.000000Z",
            "updated_at": "2021-06-07T07:27:14.000000Z",
            "pivot": {
                "patient_id": 1,
                "notification_template_id": 1,
                "created_at": "2021-06-07T07:48:45.000000Z",
                "updated_at": "2021-06-07T07:48:45.000000Z"
            }
        },
        {
            "id": 2,
            "device_id": 1,
            "notification_topic_id": 2,
            "title": "Hasil Monitoring",
            "description": "Monitoring selesai silahkan lihat hasil dan solusi penanganan yang diberikan",
            "image": "",
            "created_at": "2021-06-07T07:27:14.000000Z",
            "updated_at": "2021-06-07T07:27:14.000000Z",
            "pivot": {
                "patient_id": 1,
                "notification_template_id": 2,
                "created_at": "2021-06-07T12:09:22.000000Z",
                "updated_at": "2021-06-07T12:09:22.000000Z"
            }
        }
    ]
}
```
-   Failed:
```json
{
    "code": 400,
    "status": "gagal",
    "message": "topic tidak ada"
}
```
<!-- ============= TOPIC NOTIFICATION END -->



<!-- ============= FIREBASE TOKEN NOTIFICATION START -->
## <a name="notification_token"></a>Firebase Token Notification

#### <a name="n_token_update"></a>Update Token
Request:
-   Method: POST
-   Endpoint: 'patient/token/v1/update'
-   Header:
    -   Authorization: Bearer
    -   Content-Type: application/json
-   Body:
```json
{
    "firebaseApiToken": "firebase_token"
}
```

Response:
-   Success:
```json
{
    "code": 200,
    "status": "berhasil",
    "message": "token berhasil update"
}
```
-   Gagal:
```json
{
    "code": 400,
    "status": "gagal",
    "message": "token gagal diupdate"
}
```


#### <a name="n_token_delete"></a>Delete Token
Request:
-   Method: POST
-   Endpoint: 'patient/token/v1/delete'
-   Header:
    -   Authorization: Bearer
    -   Content-Type: application/json
-   Body:
```json
{
    "firebaseApiToken": "firebase_token"
}
```

Response:
-   Success:
```json
{
    "code": 200,
    "status": "berhasil",
    "message": "token berhasil dihapus"
}
```
-   Gagal:
```json
{
    "code": 400,
    "status": "gagal",
    "message": "token gagal dihapus"
}
```
#### <a name="n_token_get"></a>Get Token
<!-- ============= FIREBASE TOKEN NOTIFICATION END -->
<!-- ============= NOTIFICATION END =============== -->





<!-- ============= DEVICE START ============= -->
# <a name="device"></a>Device
<!-- ============= HARDWARE START ============= -->
## <a name="d_hardware"></a>Create Hardware Identifier
### <a name="dh_pasien"></a>Pasien
-   Method : POST
-   Endpoint : 'patient/hardware/create'
-   Header : 
    -   Content-Type : application/json
    -   Authorization: Bearer
-   Body:
```json
{
    "serial_number" : "serial_number_hardware"
}
```

Response:
-   Success:
```json
{
    "code": 200,
    "status": "berhasil",
    "message": "device berhasil ditambahkan",
    "device": "serial_number"
}
```

-   Failed:
```json
{
    "code": 400,
    "status": "gagal",
    "message": "device gagal ditambahkan",
}
```
<!-- ============= HARDWARE END ============= -->



<!-- ============= ANDROID START ============= -->
## <a name="d_mobile"></a>Create Android Identifier
### <a name="dm_pasien"></a>Pasien
<!-- ============= END START ============= -->



<!-- ============= ENABLE/DISABLE START ============= -->
## <a name="en_device"></a>Enable/Disable Device
### <a name="en_pasien"></a>Pasien
-   Method: POST
-   Endpoint: 'patient/hardware/enable' (menyalakan perangkat = 1)
-   Endpoint: 'patient/hardware/disable' (mematikan perangkat = 0)
-   Header: 
    -   Content-Type : application/json
    -   Authorization : Bearer
-   Body:
```json
{
    "status" : "0/1",
}
```

Response :
-   Success:
```json
{
    "code" : 200,
    "status" : "berhasil",
    "message" : "device berhasil diaktifkan/dinonaktifkan"
}
```

-   Failed :
```json
{
    "code" : 400,
    "status" : "gagal",
    "message" : "device gagal diaktifkan/dinonaktifkan"
}
```

<!-- ============= ENABLE/DISABLE END ============= -->
<!-- ============= DEVICE END ============= -->




<!-- ============= ENABLE/DISABLE START ============= -->
## <a name="en_device_serial"></a>Enable/Get Serial Number
### <a name="en_serial"></a>Pasien
-   Method: POST
-   Endpoint: 'patient/hardware/serial-number'
-   Header: 
    -   Content-Type : application/json
    -   Authorization : Bearer
-   Body:

Response :
-   Success:
```json
{
    "code" : 200,
    "status" : "berhasil",
    "serial_number" : "serial number device"
}
```

-   Failed :
```json
{
    "code" : 400,
    "status" : "gagal",
    "message" : "belum terdaftar"
}
```

<!-- ============= GET SERIAL NUMBER END ============= -->
<!-- ============= DEVICE END ============= -->




<!-- ============= MONITORING START ============= -->
# <a name="m_monitoring"></a>Monitoring
## <a name="monitoring_result"></a>Get Monitoring Result
Request:
-   Method: GET
-   Endpoint: /patient/monitoring
-   Header:
    -   Content-Type : application/json
-   Body:
```json
{
    "patient_id" : 1
}
```

Response: 
-   Success
```json
{
    "code": 200,
    "status": "success",
    "monitoring_result": {
        "averrage_spo2": "99",
        "status": "normal",
        "recomendation": "tetap jaga kesehatan anda dengan patuhi protokol kesehatan"
    }
}
```
-   Failed
```json
{
    "code": 400,
    "status": "gagal",
    "monitoring_result": "belum melakukan monitoring"
}
```
<!-- ============= MONITORING END ============= -->



<!-- ============= GEOLOCATION START ================ -->
# <a name="geolokasi"></a>Geolokasi
## <a name="patient_location"></a>Update Patient Location
### <a name="p_location_update"></a>Update
Request:
-   Method: POST
-   Endpoint: 'patient/geo-update'
-   Header:
    -   Content-Type: application/json
    -   Authorization: Bearer
-   Body:
```json
{
    "latitude": "8,1232732293",
    "longitude": "-14458029463"
}
```

Response:
-   Success:
```json
{
    "code": 200,
    "message": "success",
    "latitude": "8,1232732293",
    "longitude": "-14458029463"
}
```
-   Failed:
```json
{
    "code": 200,
    "status": "failed",
    "message": "update location failed"
}
```


<!-- Get All Patient Location Start-->
## <a name="all_patient_location"></a>Get All Patient Location
### <a name="all_location_update"></a>GET
Request:
-   Method: GET
-   Endpoint: 'patient/geolocation/all'
-   Header:
    -   Content-Type: application/json
    -   Authorization: Bearer
-   Body: none

Response:
-   Success:
```json
{
    "code": 200,
    "status": "berhasil",
    "data": [
        {
            "id": 1,
            "name": "Niki",
            "latitude": "-8.458808283281881",
            "longitude": "114.25944812277316"
        },
        {
            "id": 2,
            "name": "Yoyo",
            "latitude": "-8.507765383320798 ",
            "longitude": "114.25307836641305"
        }
    ]
}
```
-   Failed:
```json
{
    "code": 400,
    "status": "failed",
    "message": "tidak ada pasien lain yang terdaftar"
}
```
<!-- Get All Patient Location End-->
<!-- ============= GEOLOCATION END ================ -->

    

<!-- ============= MEDICAL RECORD START ================ -->
# <a name="rekam_medis"></a>Medical Record
## <a name="patient_record"></a>Rekam Medis Pasien
### <a name="petient_record_get"></a>Get
-   Method: GET
-   Endpoint: 'patient/record'
-   Header :
    -   Content-Type : application/json
- Body: 

```json
{
    "patient_id": 1
}
```

Response
-   Success
```json
{
    "code": 200,
    "status": "success",
    "patient": {
        "id": 1,
        "name": "Niki",
        "phone": "123456789",
        "photo": "profiles/1626400419.png",
        "email": "yofan.ixe@gmail.com",
        "jenis_kelamin": "Laki - Laki",
        "tanggal_lahir": "24-08-1999",
        "alamat": "Banyuwangi"
    },
    "monitoring_location": {
        "latitude": "-8.458808283281881",
        "longitude": "114.25944812277316"
    },
    "close_contacts": [
        {
            "id": 1,
            "patient_id": 1,
            "address": "Jalan Raya Jember No.KM13, Kawang, Labanasem, Kec. Kabat, Kabupaten Banyuwangi, Jawa Timur 68461",
            "name": "nini",
            "relationship": "saudara",
            "duration": "2 menit",
            "time": "10:02",
            "date": "2021-09-21",
            "latitude": "-8.318773711922141",
            "longitude": "114.28271462612766",
            "created_at": "2021-07-16T03:02:19.000000Z",
            "updated_at": "2021-07-16T03:02:19.000000Z"
        },
        {
            "id": 2,
            "patient_id": 1,
            "address": "Jalan Raya Jember No.KM13, Kawang, Labanasem, Kec. Kabat, Kabupaten Banyuwangi, Jawa Timur 68461",
            "name": "nunu",
            "relationship": "saudara",
            "duration": "2 menit",
            "time": "10:02",
            "date": "2021-09-22",
            "latitude": "-8.318773711922141",
            "longitude": "114.28271462612766",
            "created_at": "2021-07-16T03:03:02.000000Z",
            "updated_at": "2021-07-16T03:03:02.000000Z"
        }
    ],
    "device_type": "Pulse Oximetry",
    "monitoring_result": [
        {
            "id": 1,
            "patient_id": 1,
            "averrage_spo2": "99",
            "averrage_bpm": "120",
            "status": "normal",
            "recomendation": "tetap jaga kesehatan anda dengan patuhi protokol kesehatan",
            "created_at": "18, Jul 2021 15:20",
            "updated_at": "18, Jul 2021 15:20"
        },
        {
            "id": 2,
            "patient_id": 1,
            "averrage_spo2": "99",
            "averrage_bpm": "120",
            "status": "normal",
            "recomendation": "tetap jaga kesehatan anda dengan patuhi protokol kesehatan",
            "created_at": "18, Jul 2021 15:21",
            "updated_at": "18, Jul 2021 15:21"
        }
    ]
}
```

-   Failed
```json
{
    "code" : 400,
    "status": "failed",
    "message": "anda belum melakukan monitoring sebanyak 3 kali"
}
```

<!-- Medical Record Delete Start -->
### <a name="patient_record_delete"></a>Delete
-   Method: POST
-   Endpoint: 'patient/record/delete'
-   Header :
    -   Content-Type : application/json

Response
-   Success:
```json
{
    "code" : 200,
    "status": "berhasil",
    "message": "rekam medis berhasil dihapus"
}
```
-   Failed
```json
{
    "code" : 400,
    "status": "failed",
    "message": "rekam medis gagal di hapus"
}
```
<!-- Medical Record Delete End -->

<!-- ============= MEDICAL RECORD END ================ -->



<!-- ============= DEVICE START ============= -->
# <a name="pulse"></a>Pulse Oximetry
<!-- ============= INSERT SENSOR START ============= -->
## <a name="pulse_insert"></a>Insert Spo2 & Bpm
#### <a name="sen_pasien"></a>Pasien

-   Method : POST
-   Endpoint : 'oximetry/insert'
-   Header :
    -   Content-Type : application/json
-   Body:

```json
{
    "serial_number" : "serial_number_device",
    "spo2": 99,
    "bpm": 90,
    "latitude": 2174217214,
    "longitude": 21429114204,
    "backup": "file-backup.txt"
}
```
Response
- Success:
```json
{
     "message" : "data berhasil di simpan"
}
```
```json
{
    "message": "aktifkan button monitoring di aplikasi android"
}
```
<!-- ============= INSERT SENSOR END ============= -->



<!-- ============= GET DATA SENSOR START ============= -->
## <a name="pulse_get"></a>Get Data Sensor
#### <a name="pulse_data"></a>Pasien
-   Method : GET
-   Endpoint : 'oximetry/data'
-   Header : 
    -   Content-Type : application/json
-   Body :

```json
{
    "serial_number" : "serial_number_device"
}
```

Response :
-   Success :
```json
{
    "code": 200,
    "data": [
        {
            "id": 1,
            "user_device_id": 1,
            "spo2": "99",
            "bpm": "100",
            "created_at": "2021-05-05T11:26:19.000000Z",
            "updated_at": "2021-05-05T11:26:19.000000Z"
        },
        {
            "id": 2,
            "user_device_id": 1,
            "spo2": "99",
            "bpm": "100",
            "created_at": "2021-05-05T11:26:29.000000Z",
            "updated_at": "2021-05-05T11:26:29.000000Z"
        },
    ]
}
```

-   Failed 
```json
{
    "code": 400,
    "status": "gagal",
    "message": "Device tidak terdaftar"
}
```

<!-- ============= GET DATA SENSOR END ============= -->
<!-- ============= DEVICE END ============= -->