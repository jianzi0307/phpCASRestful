# CAS Restful API 的PHP实现

* CAS RESTful API:

> https://wiki.jasig.org/display/casum/restful+api


* Tomcat 9.0\webapps\cas\WEB-INF\web.xml中添加

```xml
<servlet>
    <servlet-name>restlet</servlet-name>
    <servlet-class>org.restlet.ext.spring.RestletFrameworkServlet</servlet-class>
    <load-on-startup>1</load-on-startup>
</servlet>

<servlet-mapping>
    <servlet-name>restlet</servlet-name>
    <url-pattern>/v1/*</url-pattern>
</servlet-mapping>
```
