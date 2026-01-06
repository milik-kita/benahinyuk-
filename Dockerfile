FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libzip-dev zip unzip git \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html/
WORKDIR /var/www/html

# Create necessary directories
RUN mkdir -p /var/www/html/uploads /var/www/html/logs

# Set proper ownership and permissions for Apache (www-data user)
RUN chown -R www-data:www-data /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html/logs \
    && chmod -R 777 /var/www/html/uploads \
    && chmod -R 777 /var/www/html/logs

# If a .env file isn't provided, copy the example to keep defaults
RUN if [ -f /var/www/html/.env.example ] && [ ! -f /var/www/html/.env ]; then cp /var/www/html/.env.example /var/www/html/.env; fi

# Create entrypoint script to handle permissions on container start
RUN cat > /usr/local/bin/docker-entrypoint.sh << 'EOF' \
&& chmod +x /usr/local/bin/docker-entrypoint.sh \
EOF

COPY --chown=www-data:www-data . /var/www/html/

EXPOSE 80
CMD ["apache2-foreground"]
