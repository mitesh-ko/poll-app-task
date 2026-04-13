## System requirements
- PHP 8.4^
- composer 2.8^
- node 22.12^
- npm 10.9^

## How to set up
- Clone this project

### Production
- Run command `composer install --no-dev`
- Update the .env
```
APP_ENV=production
APP_DEBUG=false
```

### Development
- Run command `composer install`
- No need to update **APP_ENV** and **APP_DEBUG**

### Common steps
- Connect database
    ```
      DB_CONNECTION=mysql (recommended)
      DB_HOST=<eg: localhost>
      DB_PORT=
      DB_DATABASE=
      DB_USERNAME=
      DB_PASSWORD=
    ```
- Run following command one by one
  - `php artisan migrate`
  - `php artisan db:seed`
  - `npm install`
  - `npm run build`

## Setup WebSocket
In this project, Pusher is used for WebSocket communication. Create an account on Pusher and configure the credentials as outlined below.
```
PUSHER_APP_ID="xxxxxxx"<Numeric app id>
PUSHER_APP_KEY=<Alphanumeric app key>
PUSHER_APP_SECRET=<Alphanumeric app secret>
PUSHER_APP_CLUSTER=<eg: ap2>
PUSHER_PORT=<eg: 443>
PUSHER_SCHEME=<eg: https>
```
How to Test Realtime Data
1. Create a poll as an admin and copy the poll URL.
2. Open the copied URL in a new tab.
3. Open the same URL in another browser (or incognito window).
4. Submit a poll answer in one browser.
5. Notice that the total answer count updates in real-time on the other tab/browser.
