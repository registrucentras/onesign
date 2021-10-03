# OneSign PHP API Client

## Reikalavimai

* PHP 7.4+ arba 8.0+

#### Patariam

* Nginx
* php-fpm

## Funkcijos

* PDF dokumentų pasirašymas;
* laiko žymų uždėjimas ant PDF dokumentų.

## Diegimas

Norėdami greitai integruoti šią biblioteką į savo PHP projektą naudokite [Composer](https://getcomposer.org) PHP paketų valdymo įrankį. Jei jūsų projektas nenaudoja PSR standartu paremtą HTTP klientą, papildomai [įdiekite vieną iš jų](https://packagist.org/providers/psr/http-client-implementation). Daugiau informacijos galite rasti [paslaugų teikimo tvarkoje](https://registrucentras.github.io/gosign-api-integration/getting-started.html).

### Standartinis diegimas

```bash
$ composer require "registrucentras/onesign:^1.0"
```

## Naudojimas

Inicijuokite API kliento objektą.

```php
use RegistruCentras\OneSign\Client;

$client = new Client();
```

### Autentifikavimas, užklausų ir atsakymų validacija

Pasirašymo paslaugos saugumas ir kliento autentifikavimas užtikrinamas naudojant asimetrinę kriptografiją:

- jūsų privatus raktas, naudojamas siunčiamam turiniui pasirašyti;
- jūsų viešas raktas (perduodamas GoSign administratoriui), naudotojui ir jo siunčiamam turiniui patvirtinti;
- viešas GoSign raktas (pateikiamas individualiai GoSign administratoriaus), užklausos atsakymo vientisumui užtikrinti.

kaip generuoti raktus pateikiama [raktų generavimo instrukcijoje](https://registrucentras.github.io/gosign-api-integration/key-generation.html).

```php
$client->configure(
  'api_endpoint_adresas',
  'jums_suteiktas_id',
  \file_get_contents(__DIR__ . '/../Keys/private.key'),
  'private_key_passprahse',
  \file_get_contents(__DIR__ . '/../Keys/public.key')
);
```

### Pavyzdžiai
### Dokumento pasirašymas
Dokumento pasirašymas vyksta keliais etapais:
- inicijuojama pasirašymo transkacija (`$client->init()`);
- asmuo, pasirašantis dokumentą, nukreipiamas į pasirašymo puslapį;
- pasirašomas dokumentas;
- asmuo, pasirašantis dokumentą, nukreipiamas į (`$client->init()`) metode nurodytą pasirašymo sėkmės puslapį;
- gaunamas pasirašytas dokumentas (`$client->result()`).

Inicijuota pasirašymą galite nutraukti (`$client->cancel()`) (iki dokumento pasirašymo).
#### Pasirašymo inicijavimas

Dokumento pasirašymo inicijavimui yra naudojami keturi esybių objektai:
- `Signer` - aprašomas pasirašantis asmuo;
- `File` - aprašomas pasirašomas failas;
- `SignatureConfiguration` - aprašoma parašo konfigūracija;
- `Configuration` - aprašoma pasirašymo konfigūracija.

```php
use RegistruCentras\OneSign\Entity\Signer;
use RegistruCentras\OneSign\Entity\File;
use RegistruCentras\OneSign\Entity\SignatureConfiguration;
use RegistruCentras\OneSign\Entity\Configuration;
use RegistruCentras\OneSign\Entity\SigningType;

$signer = (new Signer())
  ->setPersonalCode('asmens_kodas')
  ;
  
$file = (new File())
  ->setName('failo_pavadinimas')
  ->setContent(\file_get_contents(__DIR__ . '/../Files/sample.pdf'))
  ;
  
$signatureConfiguration = new SignatureConfiguration();

$configuration = (new Configuration())
  ->setResponseUrl('http://example.com/backlink')
  ->setSigningType(SigningType::SIGNATURE_WITH_TIMESTAMP_OCSP)
  ;

$response = $client
  ->init($signer, $file, $signatureConfiguration, $configuration)
  ;

$transactionId = $response->getTransactionId();
        
$signingUrl = $response->getSigningUrl();
```

rezultate gauname:
- `transactionId` - pasirašymo transakcijos unikalus numeris;
- `signingUrl` - pasirašymo puslapio adresas, į kurį bus nukreipiamas pasirašytojas.

Daugiau veikiančių pavyzdžių galite rasti [kliento testavimo scenarijuose](tests/IntegrationTest.php).

#### Pasirašymo transakcijos būsenos patikrinimas ir pasirašyto failo gavimas

Pasirašyto dokumento gavimui yra naudojamas vienas esybių objektas:
- `Transaction` - pasirašymo transakcijos unikalus numeris gautas iš pasirašymo inicijavimo etapo.

```php
use RegistruCentras\OneSign\Entity\Transaction;
use RegistruCentras\OneSign\HttpClient\Message\Response\Status\SigningResponseStatus;

$transaction = (new Transaction())
  ->setTransactionId($transactionId)
  ;

$response = $client
  ->result($transactionId)
  ;

$status = $response->getStatus();
```

rezultate gauname:
- `status` - pasirašymo transakcijos būsena (`SigningResponseStatus::IN_PROGRESS` - pasirašymas inicijuotas, laukiama dokumento pasirašymo, `SigningResponseStatus::SIGNED` - dokumentas pasirašytas, `SigningResponseStatus::CANCELED` - dokumento pasirašymas buvo nutrauktas);

prie `SigningResponseStatus::SIGNED` pateikiami papildomi parametrai:
- `file` - failo esybės objektas;

gaukite pasirašyto failo pavadinimą:
```php
$fileName = $response->getFile()->getFileName();
```
gaukite pasirašyto failo turinį:
```php
$fileContent = $response->getFile()->geContent();
```
- `signerCertificate` - asmens, kuris pasirašė dokumentą, sertifikatas;
```php
$signerCertificate = $response->getSignerCertificate();
```
- `signerCertificateTrusted` - asmens, kuris pasirašė dokumentą, sertifikato validumas (boolean: `true` - validus, `false` - ne validus).
```php
$signerCertificateTrusted = $response->getSignerCertificateTrusted();
```
#### Pasirašymo nutraukimas

Pasirašymo nutraukimui yra naudojamas vienas esybių objektas:
- `Transaction` - pasirašymo transakcijos unikalus numeris gautas iš pasirašymo inicijavimo etapo.

```php
use RegistruCentras\OneSign\Entity\Transaction;
use RegistruCentras\OneSign\HttpClient\Message\Response\Status\CancelSigningResponseStatus;

$transaction = (new Transaction())
  ->setTransactionId($transactionId)
  ;

$response = $client
  ->cancel($transactionId)
  ;

$status = $response->getStatus();
```

rezultate gauname:
- `status` - pasirašymo transakcijos būsena (`CancelSigningResponseStatus::CANCELED` - pasirašymas buvo nutrauktas, `CancelSigningResponseStatus::ERROR` - pasirašymo nutraukti nepavyko);

## Atitiktis

* [Standard PHP package skeleton](https://github.com/php-pds/skeleton);
* HTTP message interfaces (PSR-7);
* HTTP Server Request Handlers, Middleware (PSR-15);
* HTTP factories (PSR-17);
* Code styles (PSR-12);
* PHPDoc standartas (PSR-5, PSR-19);
* Unit and integration testai;
* Ištestuota su [Github Actions](https://github.com/registrucentras/onesign/actions);
* [PHPStan](https://github.com/phpstan/phpstan) (Level: max);
* Docker konteineris su Xdebug palaikymu.

## Plėtra

Esame atviri atviro kodo politikai. Norite prisidėti prie projekto? Visada laukiame pakeitimų. Kaip tai padaryti? Atlikite pakeitimus atskiroje kodo atšakoje ir siųkite „Pull“ užklausas į pagrindinę kodo atšaką. Prašome tik:
- vadovautis [Symfony karkaso standartais](https://symfony.com/doc/current/contributing/code/standards.html);
- įsitikinti, kad po pakeitimo esami testai veikia tinkamai;
- įsitikinti, kad pakeitimas yra "padengtas" testu;
- vykdyti nuoseklią kodo versijų kontrolę: kiekvieno pakeitimo aprašymas yra prasmingas;
- naudoti [rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing) kad išvengumėte konfilktų;
- nepamiršti ir dokumentacijos;
- statiniam kodui skenuoti naudoti [psalm](https://psalm.dev/) ir [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer);
- kodo kokybei užtikrinti naudoti [phpstan](https://github.com/phpstan/phpstan);
- automatiniam refaktorinimui naudoti [rector](https://github.com/rectorphp/rector).

## Nuo ko pradėti?

Įsitikinkite, kad jūsų darbo vieta palaiko `Docker` ir komandų vykdymo `Make` PĮ.

```bash
$ git clone
$ make install
```

Paleiskite automatinius testus ir kodo analizės įrankius:

```bash
$ make test
```
