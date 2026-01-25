# Stage 1: Build environment and Composer dependencies
FROM php:8.4-cli AS builder

# Install system dependencies and PHP extensions required for Laravel + MySQL/PostgreSQL support
# Some dependencies are required for PHP extensions only in the build stage
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    libpq-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    opcache \
    intl \
    zip \
    bcmath \
    soap \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Set the working directory inside the container
WORKDIR /var/www

# Copy the entire Laravel application code into the container
COPY . /var/www

# Install Composer and dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# Stage 2: Production environment
FROM php:8.4-cli

# Install client libraries required for php extensions in runtime
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Copy PHP extensions and libraries from the builder stage
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /usr/local/bin/docker-php-ext-* /usr/local/bin/

# Use the default production configuration for PHP runtime arguments
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy the application code and dependencies from the build stage
COPY --from=builder /var/www /var/www

# Set working directory
WORKDIR /var/www

# Ensure correct permissions
RUN chown -R www-data:www-data /var/www

# Switch to the non-privileged user to run the application
USER www-data

# Default command: Provide a bash shell to allow running any command
CMD ["bash"]