FROM richarvey/nginx-php-fpm:latest

# Copy application files
COPY . /var/www/html

# Configure Environment Variables for richarvey/play-with-docker
ENV PLAYWITHDOCKER_PORT=80
ENV WEBROOT=/var/www/html/public
ENV COMPOSER_PROVIDE_AUTOLOAD=1
ENV RUN_SCRIPTS=1

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Install npm dependencies and build assets
RUN apk add --no-cache nodejs npm && \
    npm install && \
    npm run build

# Expose port 80
EXPOSE 80
