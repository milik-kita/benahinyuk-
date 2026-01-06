# Multi-stage build for optimized image size
FROM php:8.2-apache AS builder

# Install PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    && docker-php-ext-install \
       mysqli \
       pdo \
       pdo_mysql \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Final runtime stage
FROM php:8.2-apache

# Copy PHP extensions from builder
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Install only runtime dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Enable Apache modules
RUN a2enmod rewrite headers && a2dismod status cgi-bin

# Security hardening
RUN echo 'ServerTokens Prod' >> /etc/apache2/apache2.conf && \
    echo 'ServerSignature Off' >> /etc/apache2/apache2.conf && \
    echo 'Header always unset X-Powered-By' >> /etc/apache2/apache2.conf && \
    echo 'Header unset X-Powered-By' >> /etc/apache2/apache2.conf

# Copy application code
COPY --chown=www-data:www-data . /var/www/html/
WORKDIR /var/www/html

# Create necessary directories with proper permissions
RUN mkdir -p /var/www/html/uploads /var/www/html/logs && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 775 /var/www/html/uploads && \
    chmod -R 775 /var/www/html/logs

# Copy .env if exists
COPY --chown=www-data:www-data .env.example* ./
RUN if [ -f .env.example ] && [ ! -f .env ]; then cp .env.example .env; fi

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=10s --retries=3 \
    CMD curl -f http://localhost/ || exit 1

EXPOSE 80
CMD ["apache2-foreground"]
