# URLshorting
[![](https://data.jsdelivr.com/v1/package/gh/soxft/Urlshorting/badge)](https://www.jsdelivr.com/package/gh/soxft/Urlshorting)
<a href="http://www.apache.org/licenses/LICENSE-2.0.html"> 
<img src="https://img.shields.io/github/license/soxft/URLshorting.svg" alt="License"></a>
<a href="https://github.com/soxft/URLshorting/stargazers"> 
<img src="https://img.shields.io/github/stars/soxft/URLshorting.svg" alt="GitHub stars"></a>
<a href="https://github.com/soxft/URLshorting/network/members"> 
<img src="https://img.shields.io/github/forks/soxft/URLshorting.svg" alt="GitHub forks"></a> 

## Introduction

A URL shortening platform.

demo：[K6o short link](https://www.k6o.top/)

## installation method
1. Download the source code.<br/>
2. Upload to the root directory of your website.<br/>
3. Visit the website domain name and fill in mysql and other information to install<br/>
4. Modify the pseudo-static configuration of the website:<br/>

Nginx:  
```
    if (!-e $request_filename) {
    rewrite ^/(.*)$ /index.php?id=$1 last;
    }
```

Apache:
```
    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ /index.php?id=$1 [L]
    </IfModule>
```

IIS (For reference only, not tested):
```
  <rule name="tool.apizl.com rewriteTools1" patternSyntax="ECMAScript" stopProcessing="true">
    <match url="^/(.*)" ignoreCase="false" />
    <conditions logicalGrouping="MatchAll" trackAllCaptures="false" />
    <action type="Rewrite" url="/index.php?id={R:1}" appendQueryString="false" />
  </rule>
```


<br/>5.Visit the website to confirm.

## copyright
xcsoft All rights reserved. The source code is open sourced according to the apache2 open source agreement. Please do not modify the copyright information!
   <p>Secondary Developed By k6o.top</p>
   <p>Contact us: Gary@dtnetwork.top</p>

## Update
v2.2.1 update
<br/>This update is provided by k6o short link
   <p>email: Gary@dtnetwork.top</p>
<br/>Add English translation
