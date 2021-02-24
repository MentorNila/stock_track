Catchall Vhost Set up
=====================

After we set up the laravel environment  we have to set up a “catchall” virtual host, also called a “wild card” virtual host. This virtual host makes it possible to use one top level domain on your local, and automatically have its subdomains map to a given documentroot on your local, following a certain pattern.

Additionally, a local DNS server (we are using Dnsmasq) can send all requests for a certain domain to your localhost, so you don’t have to worry about adding entries to your hosts file ever again.

Below are the steps to accomplish this.


## Set up catchall vhost

1. Enable Apache’s vhost_alias module: sudo a2enmod vhost_alias
2. Create /etc/apache2/sites-available/catchall.conf:   
    <VirtualHost *:80>   
        ServerAlias localhost *.iedgar.loc #wildcard catch all   
        VirtualDocumentRoot /var/www/iedgar/public   
        UseCanonicalName Off   
        <Directory /var/www>  
            Options +FollowSymlinks  
            AllowOverride All  
            Order allow,deny  
            Allow from all  
            Require all granted  
        </Directory>  
    </VirtualHost>
3. Enable the virtual host configuration: sudo a2ensite /etc/apache2/sites-available/catchall.conf
4. Reload the Apache configuration: sudo service apache2 reload


## Configure local wildcard DNS server

1. Install Dnsmasq: sudo apt-get install dnsmasq
2. Open up /etc/NetworkManager/NetworkManager.conf and comment out the line that reads dns=dnsmasq and restart NetworkManager afterwards: sudo restart network-manager
3. Make sure Dnsmasq listens to local DNS queries by editing /etc/dnsmasq.conf, and adding the line listen-address=127.0.0.1
4. Create a new file in /etc/dnsmasq.d (ex.  /etc/dnsmasq.d/iedgar)  and uncomment the lines:  
   - port=53  
   - domain-needed  
   - bogus-priv  
   - strict-order  
   - listen-address=127.0.0.1  
   - bind-interfaces  
   - expand-host  
 and restart Dnsmasq: sudo /etc/init.d/dnsmasq restart
  

## Have your localhost resolve domain names  

You’ll need to let your localhost resolve domain names we request.
To do this, open the file /etc/dhcp/dhclient.conf, and uncomment the line #prepend domain-name-servers 127.0.0.1 and refresh your local DNS handling by typing: sudo dhclient


## Set up DNS servers

Open the file /etc/resolv.conf and add the lines:  
 - search .  
 - options timeout:1   
 - options rotate  
 - nameserver 127.0.0.1  
 - nameserver 8.8.8.8

But the edits in this file are ephemeral. If you restart your machine they’ll be overwritten by default content.
Below are the steps how we can fix this:  
 - Install resolvconf package: sudo apt install resolvconf  
 - Edit /etc/resolvconf/resolv.conf.d/head and add the lines we added to /etc/resolv.conf  
 - Restart the resolvconf service: sudo service resolvconf restart

And the fix should be permanent.  

