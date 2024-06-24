# 使用官方 PHP 8.1 镜像作为基础镜像
FROM php:8.1-fpm

# 设置工作目录
WORKDIR /var/www/html

# 安装系统依赖和 PHP 扩展
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# 配置并安装 PHP 扩展
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
        pdo \
        pdo_mysql \
        zip

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install

# 将所有文件的拥有者设置为 www-data 用户
RUN chown -R www-data:www-data /var/www/html

# 使用 www-data 用户运行进程
USER www-data

# 暴露 PHP-FPM 的默认端口
EXPOSE 9000

# 容器启动命令
CMD ["php-fpm"]
