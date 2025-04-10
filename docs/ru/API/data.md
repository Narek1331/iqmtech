---
title: Интеграция по API
icon: heroicon-o-book-open
---

# ⚙️ Инструкция по использованию API синхронизации данных

Данное API предназначено для синхронизации данных и поддерживает передачу параметров как через URL, так и в теле запроса (body).

## 📡 Метод запроса

**POST**

## 🔗 URL

`https://iqmtech.ru/api/sync/data`

Параметры могут быть добавлены непосредственно к URL после знака вопроса `?`.

## 🔑 Заголовки (Headers)

При каждом запросе необходимо включать следующие заголовки:

* `Authorization`: `Bearer <ваш_токен>`
    * `<ваш_токен>`: Ваш персональный токен авторизации.
* `Content-Type`: `application/json`
    * Указывает, что тело запроса (при наличии) должно быть в формате JSON.

## 📤 Параметры

API позволяет передавать параметры двумя способами:

**1. 🌐 Через URL (Query Parameters):**

Параметры добавляются к URL после знака вопроса `?` и разделяются амперсандом `&`.

**Пример:**

https://iqmtech.ru/api/sync/data?page=http://localhost&ref=http://localhost&phone=%2B7%20925%20203-23-40&browser=Chrome&device=iPhone&platform=iOS&ip_address=192.168.1.1&utm_term=search-term&utm_source=google&utm_campaign=spring_sale&utm_medium=email&utm_content=promo_code&latitude=40.7128&longitude=-74.0060&gender=male&age=30


В этом примере передаются следующие параметры:

* `page`: `http://localhost`,
* `ref`: `http://localhost`,
* `phone`: `+7 925 203-23-40`,
* `browser`: `Chrome`,
* `device`: `iPhone`,
* `platform`: `iOS`,
* `ip_address`: `192.168.1.1`,
* `utm_term`: `search-term`,
* `utm_source`: `google`,
* `utm_campaign`: `spring_sale`,
* `utm_medium`: `email`,
* `utm_content`: `promo_code`,
* `latitude`: `40.7128`,
* `longitude`: `-74.0060`,
* `gender`: `male`,
* `age`: `30`

**2. 📦 Через тело запроса (Request Body):**

Параметры передаются в формате JSON в теле POST-запроса. Этот метод рекомендуется для передачи более сложной структуры данных или больших объемов информации.

**Пример тела запроса (JSON):**

```json
{
    "page": "http://localhost",
    "ref": "http://localhost",
    "phone": "+7 925 203-23-40",
    "browser": "Chrome",
    "device": "iPhone",
    "platform": "iOS",
    "ip_address": "192.168.1.1",
    "utm_term": "search-term",
    "utm_source": "google",
    "utm_campaign": "spring_sale",
    "utm_medium": "email",
    "utm_content": "promo_code",
    "latitude": "40.7128",
    "longitude": "-74.0060",
    "gender": "male",
    "age": "30"
}

📝 Дополнительные параметры (опционально)

Следующие параметры могут быть переданы как через URL, так и в теле запроса (в формате JSON):

    page: string (до 255 символов), обязательный
    ref: string (до 255 символов), может быть пустым (nullable)
    phone: string (до 20 символов), может быть пустым (nullable)
    browser: string (до 255 символов), может быть пустым (nullable)
    device: string (до 255 символов), может быть пустым (nullable)
    platform: string (до 255 символов), может быть пустым (nullable)
    ip_address: string, может быть пустым (nullable)
    utm_term: string (до 255 символов), может быть пустым (nullable)
    utm_source: string (до 255 символов), может быть пустым (nullable)
    utm_campaign: string (до 255 символов), может быть пустым (nullable)
    utm_medium: string (до 255 символов), может быть пустым (nullable)
    utm_content: string (до 255 символов), может быть пустым (nullable)
    latitude: numeric|string, может быть пустым (nullable)
    longitude: numeric|string, может быть пустым (nullable)
    gender: string (до 255 символов), может быть пустым (nullable)
    age: string (до 255 символов), может быть пустым (nullable)
