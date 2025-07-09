# 🐧 ResitCrazy88 PHP Application Setup (Ubuntu + Apache)

This guide walks you through setting up the **ResitCrazy88** PHP application on an Ubuntu server with Apache. It includes installation steps, Apache configuration, file permissions, and data folder setup.

---

## ✅ Prerequisites

Ensure you have the following installed:
- Ubuntu 20.04+
- Apache2
- PHP 7.4+ (or 8.x)
- `php-json` and `php-mbstring` modules
- Git (optional)

---

## 🛠️ 1. Install Apache and PHP

```bash
sudo apt update
sudo apt install apache2 php libapache2-mod-php php-json php-mbstring unzip
```

Restart Apache:

```bash
sudo systemctl restart apache2
```

---

## 📦 2. Deploy the Application

Place the project inside Apache’s document root (e.g. `/var/www/`):

```bash
sudo cp -r ResitCrazy88 /var/www/
```

Or if cloning from git:

```bash
cd /var/www/
sudo git clone <https://github.com/YenPhan1708/ResitCrazy88.git> ResitCrazy88
```

---

## 🔐 3. Set Folder Permissions (Required for JSON Read/Write)

The application needs write access to the `json/` folder which contains:
- `data.json`
- `tasks.json`

Run:

```bash
sudo chown -R www-data:www-data /var/www/ResitCrazy88/json
sudo chmod -R 755 /var/www/ResitCrazy88/json
sudo chmod 664 /var/www/ResitCrazy88/json/*.json
```

---


## 🌐 4. Access the Application

Navigate to your browser:

```
http://your-server-ip/ResitCrazy88/pages/add_group.php
```

---

## 📎 Directory Structure Summary

```
ResitCrazy88/
├── css/
├── img/
├── json/
│   ├── data.json
│   └── tasks.json
├── pages/
│   ├── add_group.php
│   ├── add_group_member.php
│   ├── leaderboard.php
│   ├── mark_task_completion.php
├── scripts/
│   ├── save_members.php
│   ├── mark_task.php
│   ├── renderRanking.php
│   └── reset_data.php
```

---

## 🙋 Need Help?
Make sure to check Apache error logs for issues:
```bash
sudo tail -f /var/log/apache2/error.log
```
