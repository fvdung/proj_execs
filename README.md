## Setup

### 1. Clone [respository](https://github.com/fvdung/proj_execs)
    git clone https://github.com/fvdung/proj_execs.git

### 2. Install composer
    cd proj_execs
    composer install

### 3. Config enviroment
    cp config/.env.example config/.env

### 4. Edit env
    `BANKID_PATH_TO_CACERT` is absolute path to `cacert.pem` file in `certificate` folder.
    `BANKID_PATH_TO_CERT` is absolute path to `cert.pem` file in `certificate` folder.

### 5. Run php-fpm server
    bin/cake server -p 8765


Then visit `http://localhost:8765/auth` to see the welcome page.