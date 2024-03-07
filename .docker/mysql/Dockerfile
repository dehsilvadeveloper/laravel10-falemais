FROM mysql:8.0.32

# Copy custom MySQL configuration file
COPY custom.cnf /etc/mysql/my.cnf

# Set the user
RUN usermod -u 1000 mysql