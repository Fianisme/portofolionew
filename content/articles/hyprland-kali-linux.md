---
title: "Menjinakkan Hyprland di Kali Linux: Catatan Ngoprek Setelan Bar, SDDM, hingga Skrip Baterai Custom"
excerpt: "Hyprland over debian linux distros"
category: "SoL"
date: "2026-06-03"
image: "storage/uploads/WjVnZZnMWr1TqNJxLmL1pZspjCxHz8vWmc8HXNcy.png"
---

Bagi para pencinta Linux, beralih ke *Window Manager* berbasis Wayland seperti **Hyprland** adalah sebuah kepuasan tersendiri. Namun, membangun ekosistem desktop yang estetik sekaligus fungsional dari nol bukanlah perkara mudah. Selalu ada drama *glitch*, config korup, hingga salah jalur *path* sistem.

Artikel ini merangkum catatan perjalanan dan tindakan teknis yang saya lakukan untuk membenahi beberapa fitur krusial di sistem Kali Linux bertenaga Hyprland saya.

## 1. Drama Modifikasi SDDM (Layar Login)

Perjalanan dimulai dari keinginan untuk mengganti tema layar login (SDDM) bawaan agar lebih estetik menggunakan tema populer *Sugar Candy*.

- **Masalah:** Perintah `git clone` terus-menerus meminta autentikasi/password meskipun repositori tersebut publik. Upaya mengunduh paksa versi `.zip` via `curl` sempat gagal (korup) karena pemblokiran *User-Agent* dari sisi server. Selain itu, biner `sddm-greeter` di Kali Linux modern disembunyikan dari `$PATH` global (berada di `/usr/lib/sddm/sddm-greeter`).

- **Solusi Akhir:** Mengalihkan pilihan ke tema resmi yang stabil dan tersedia langsung di repositori Debian/Kali, yaitu `sddm-theme-breeze`. Tema ini diaktifkan secara bersih melalui konfigurasi terpusat di `/etc/sddm.conf.d/theme.conf`.

## 2. Menyelamatkan Waybar yang "Pingsan"

Setelah melakukan proses *log out* sistem untuk menguji perubahan tema SDDM, panel status **Waybar** mendadak mati total dan menolak untuk menyala kembali.

- **Masalah:** Saat dijalankan manual via terminal, muncul pesan error:

> `Error parsing JSON: * Line 1, Column 1. Syntax error: value, object or array expected.`

Ternyata, sistem membaca sebuah file duplikat rusak bernama `config` (tanpa ekstensi) di direktori `~/.config/waybar/`, sehingga membuat proses *parsing* Waybar mengalami *crash*.

- **Solusi:** Menghapus file `config` yang korup tersebut, lalu membuat pintasan resmi (*symbolic link*) yang mengarah langsung ke file konfigurasi asli kita yang bersih (`config.jsonc`) menggunakan perintah:

```bash
ln -s ~/.config/waybar/config.jsonc ~/.config/waybar/config
```

## 3. Fitur Notifikasi Low Battery

Kehilangan daya laptop secara tiba-tiba saat asyik bekerja di **Window Manager** minimalis adalah mimpi buruk. Solusinya adalah membuat fitur pengingat otomatis.

**Langkah 1:** Membuka file konfigurasi utama Hyprland:

```bash
nano ~/.config/hypr/hyprland.conf
```

**Langkah 2:** Menambahkan blok kode *inline daemon* ini di baris paling bawah:

```bash
exec-once = bash -c '
NOTIFIED_LOW=false;
NOTIFIED_CRITICAL=false;
while true; do
    BATTERY_LEVEL=$(cat /sys/class/power_supply/BAT1/capacity);
    BATTERY_STATUS=$(cat /sys/class/power_supply/BAT1/status);
    if [ "$BATTERY_STATUS" = "Discharging" ]; then
        if [ "$BATTERY_LEVEL" -le 20 ] && [ "$NOTIFIED_LOW" = false ]; then
            notify-send -u normal -i battery-low "Baterai Lemah!" "Sisa baterai tinggal $BATTERY_LEVEL%. Colok charger gih, Fian.";
            NOTIFIED_LOW=true;
        elif [ "$BATTERY_LEVEL" -le 10 ] && [ "$NOTIFIED_CRITICAL" = false ]; then
            notify-send -u critical -i battery-empty "BATERAI KRITIS!" "Sisa baterai $BATTERY_LEVEL%! Laptop mau mati, buruan colok charger!";
            NOTIFIED_CRITICAL=true;
        fi;
    else
        NOTIFIED_LOW=false;
        NOTIFIED_CRITICAL=false;
    fi;
    sleep 60;
done'
```

## Kesimpulan

Ngoprek Linux bukan hanya soal mempercantik visual, tapi bagaimana menyelaraskan efisiensi sistem dengan kenyamanan alur kerja kita. Dengan menyatukan skrip krusial ke `hyprland.conf` dan menyuntikkan fungsi CLI ke `.zshrc`, proses pemeliharaan sistem ke depannya menjadi jauh lebih ringkas.

**Happy Ricing!**
