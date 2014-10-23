
# Install FOSOAuthServerBundle

{
    "require": {
        // ...
        "friendsofsymfony/oauth-server-bundle": "dev-master"
    }
}

# Enable the bundle

<?php
```
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
    );
}
```

# 创建数据表

需要数据库存储如下内容：

  * Client (OAuth2 consumers)
  * AccessToken
  * RefreshToken
  * AuthCode


# 配置 security.yml

```
# app/config/security.yml
security:
    firewalls:
        oauth_api:
            pattern:    ^/api
            fos_oauth:  true
            stateless:  true
            anonymous:  false # can be omitted as its default value

        oauth_token:
            pattern:    ^/oauth/v2/token
            security:   false

        oauth_authorize:
            pattern:    ^/oauth/v2/auth
            # Add your favorite authentication process here

    access_control:
        - { path: ^/api, roles: [ IS_AUTHENTICATED_FULLY ] }
```

由于 Symfony2 的 Firewall 是按照顺序进行进行加载的，因此 `oauth_api` 项应该位于 `secured_area` (pattern: ^/) 项之前。


# 配置 FOSOAuthServerBundle
配置路由：

```
# app/config/routing.yml
fos_oauth_server_token:
    resource: "@FOSOAuthServerBundle/Resources/config/routing/token.xml"

fos_oauth_server_authorize:
    resource: "@FOSOAuthServerBundle/Resources/config/routing/authorize.xml"
```


```
# app/config/config.yml
fos_oauth_server:
    db_driver: orm       # Driver availables: orm, mongodb, or propel
    client_class:        Acme\ApiBundle\Entity\Client
    access_token_class:  Acme\ApiBundle\Entity\AccessToken
    refresh_token_class: Acme\ApiBundle\Entity\RefreshToken
    auth_code_class:     Acme\ApiBundle\Entity\AuthCode
```


创建Client：
```
$clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
$client = $clientManager->createClient();
$client->setRedirectUris(array('http://www.example.com'));
$client->setAllowedGrantTypes(array('token', 'authorization_code'));
$clientManager->updateClient($client);

$router = $this->getContainer()->get('router');
$authUrl = $router->generate('fos_oauth_server_authorize', array(
    'client_id' => $client->getPublicId(),
    'redirect_uri' => 'http://www.example.com',
    'response_type' => 'code',
));
```

获取code：
http://127.0.0.1:8000/oauth/v2/auth?client_id=2_2nakzg2ci42sk0w8ogo0sgko0888ssoswwo0g00ogsc4wgkwwk&redirect_uri=http%3A%2F%2F127.0.0.1%3A8000&response_type=code

获取access_token：
http://127.0.0.1:8000/oauth/v2/token?grant_type=authorization_code&client_id=2_2nakzg2ci42sk0w8ogo0sgko0888ssoswwo0g00ogsc4wgkwwk&client_secret=34io8afoercw0cog8sgkkw4cgwk00scco4k0488gcg40g40wwc&redirect_uri=http%3A%2F%2F127.0.0.1%3A8000&code=ZGQ2OGY1OWZlYmEwZmQxOWIwYWY3NzNiNTcxZGEwMWUyMDVkMmE3NWJkNGExZDM4OTE5NTBkNGU2NTczMWVjYg

{"access_token":"NGM0MjVlNjRkZjE4M2QzMDI2MmQ0OGQ5OWIwOWM0MGI0ZGEyNzdhYTIwNTRlN2E3NmJkMGE1NTQ0NGI3MWUxZg","expires_in":3600,"token_type":"bearer","scope":null,"refresh_token":"ZmY3NzczYzAwMWZiODI4NzMzMGMzZDRkZGE5ZjA2ZmYyN2U0YTc0MWE5ZGM0ZDRhNzlhMjIxMzc4NDBmZjA0Yw"}

# 修改认证页面
复制模板文件 `authorize_content.html.twig` 到 `app/Resources/FOSOAuthServerBundle/views/Authorize/`



基本流程：

1.打开授权页面
  检查 client_id 是否有效；
  检查 redirect_uri 是否有效；
   -- 检查 scope 参数 (https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/blob/master/Resources/doc/dealing_with_scopes.md)

2.检查用户是否已登录
  若没有登录则提示登录；
  若已经登录则检查该用户之前是否授权过该应用
    若授权过则直接跳转至回调页面；
    若没有授权过，并且选择授权之后记录授权状态并跳转至回调页面
    参考 OAuthEvent https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/blob/master/Resources/doc/the_oauth_event_class.md

3.获取token页面
  检查 client_id 是否有效;
  检查 client_secret 是否有效；
  松果 grant_type 是否有效；

  若 grant_type 为 authorization_code 则检查 code 和 redirect_uri
  若 grant_type 为 password 则检查 username 和 password

grant_type 类型扩展： https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/blob/master/Resources/doc/adding_grant_extensions.md



