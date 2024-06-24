# 使用官方 PHP 8.1 镜像作为基础镜像
FROM php:8.1-fpm

# 安装系统依赖和 PHP 扩展
RUN apt-get update && \
    apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zlib1g-dev \  # 新增：安装 zlib1g-dev 作为 zip 扩展的依赖
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd \
        pdo \
        pdo_mysql \
        zip   # 新增：安装 zip 扩展

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 设置工作目录
WORKDIR /var/www/html

# 复制项目文件到工作目录
COPY . .

# 执行 Composer Install
RUN composer install --optimize-autoloader --no-dev

# 将所有文件的拥有者设置为 www-data 用户
RUN chown -R www-data:www-data /var/www/html

# 使用 www-data 用户运行进程
USER www-data

# 暴露 PHP-FPM 的默认端口
EXPOSE 9000

# 容器启动命令
CMD ["php-fpm"]
