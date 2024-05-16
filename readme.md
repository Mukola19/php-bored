## Php Bored

Requires `php: >=7.4 `



#### Composer autoload
```bash
composer dump-autoload
```


#### Get advice 
###### Parameters

* --participants=int (1-8)
* --type=string ('education', 'recreational', 'social', 'diy', 'charity', 'cooking', 'relaxation', 'music', 'busywork')
* --sender=string ('file', 'console')

```bash
php command get:advice --participants=1 --type=education --sender=console
```

