

# Alfresco Client for Laravel
Accéder au client aux API Alfresco (Rest et CMIS)

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Installation
```bash
composer require souidev/alfresco-laravel:"@dev"
``` 

## Configuration
Vous pouvez configurer le package via le fichier `.env` de l'application. Voici les paramètres disponibles :

Parametre | Description                                                     | Value
--- |-----------------------------------------------------------------| --- 
ALFRESCO_URL | base API Url                                                    | `http://ip_or_domain:port/alfresco/`
ALFRESCO_API | Api type                                                        | `rest` / <ins>`cmis`</ins> 
ALFRESCO_API_VERSION  | version                                                         | `1.0` (rest) / <ins>`1.1`</ins> (cmis)
ALFRESCO_REPOSITORY_ID  | Repository ID                                                   | `-default-` per defecte
ALFRESCO_BASE_ID  | ID Alfresco du répertoire de base                               |  
ALFRESCO_BASE_PATH  | Chemin du répertoire de base                                    |  
ALFRESCO_USER  | Utilisateur                                                     |  
ALFRESCO_PASSWORD  | Mot de passe                                                    | --- 
ALFRESCO_DEBUG  | Mode debug (activer plus de journaux)                           | `true` / <ins>`false`</ins>
ALFRESCO_REPEATED_POLICY  | Politique à suivre en cas de téléchargement d'un fichier répété | <ins>`rename`</ins> / `overwrite` / `deny`
ALFRESCO_EXPLORER  | Activer un [explorateur de fichiers](#explorer)                 | `true` / <ins>`false`</ins> 
ALFRESCO_VERIFY_SSL  | Activer la vérification SSL du serveur                   | `true` / <ins>`false`</ins>  



Alternativement, vous pouvez publier le fichier de configuration du package avec la commande :

```bash
php artisan vendor:publish --tag=souidev-alfresco
```

Cela copiera le fichier `alfresco.php` au dossier `config`.

 

## nous
Une fois configuré, le package est prêt à être utilisé.
Vous pouvez le faire des manières suivantes :


**Grâce à un `Facade`:**
```php
use Alfresco;
...
public  function  test(){
    $file=Alfresco::getDocument("xxx-yyy-zzz");
    ...
}
```

Pour Laravel < 5.6, vous devez enregistrer l'alias Facade dans le fichier `config/app.php` :
 
```php
'aliases'  =>  [
    ...
    'Alfresco'  =>  Souidev\AlfrescoLaravel\Facades\Alfresco::class
]
```

  

**Via injection de dépendances:**
À vos controller, helpers, model:


```php
use Souidev\AlfrescoLaravel\Models\AlfrescoService;
...

public  function  test(AlfrescoService  $client){
    $file=$client->getDocument("xxx-yyy-zzz");
    ...
}
```

**via la fonction `helper`:**
```php
...
public  function  test(){
    $file=alfresco()->getDocument("xxx-yyy-zzz");
    ...
}
```

  
  

## Funcions

fonction | Description | paramètres | retour | Excepcions
--- | --- | --- | --- | ---
**getBasepath** | Renvoie le répertoire racine à partir duquel les autres méthodes seront exécutées |  | `string` | 
**setBasepath** | Définit le répertoire racine à partir duquel les autres méthodes seront exécutées | `string:$path`|  
**getBaseFolder** | Renvoie le BaseFolder (le répertoire racine du chemin de base, s'il est défini) | | `AlfrescoFolder` |	
**exists** | Renvoie si un objet avec l'ID transmis existe | `string:$objectId` | `boolean` |
**existsPath** | Renvoie si un objet avec le chemin transmis existe | `string:$objectPath` | `boolean` |
**getObject** | Renvoie un objet avec l'ID transmis | `string:$objectId` |  `AlfrescoObject` | 
**getObjectByPath** | Renvoie un objet avec le chemin transmis | `string:$objectPath` | `AlfrescoObject` | 
**downloadObject** | Télécharge le contenu d'un objet en passant son ID | `string:$objectId`<br/> `boolean:$stream=false` | Binary Content |  `AlfrescoObjectNotFoundException`
**getFolder** | Retorna una carpeta d'Alfresco passant el seu ID | `string:$folderId` | `AlfrescoFolder` |  `AlfrescoObjectNotFoundException`
**getFolderByPath** | Renvoie un dossier Alfresco en passant son chemin (depuis le chemin de base) | `string:$folderPath` | `AlfrescoFolder` |  `AlfrescoObjectNotFoundException`
**getParent** | Renvoie le dossier parent de l'objet avec l'ID transmis | `string:$objectId` | `AlfrescoFolder` |  `AlfrescoObjectNotFoundException`
**getChildren** | Renvoie les enfants d'un dossier Alfresco en passant leur identifiant | `string:$folderId` | `AlfrescoFolder[]` |  `AlfrescoObjectNotFoundException`
**createFolder** | Crée un dossier en passant son nom dans le dossier avec l'ID transmis.<br>Renvoie le dossier créé | `string:$folderName`<br>`string:$parentId=null` | `AlfrescoFolder` |  `AlfrescoObjectNotFoundException`<br>`AlfrescoObjectAlreadyExistsException`
**getDocument** | Renvoie un document Alfresco en passant son ID | `string:$documentId` | `AlfrescoDocument` |  `AlfrescoObjectNotFoundException`
**getDocumentByPath** | Renvoie un document Alfresco en passant son chemin (depuis le chemin de base) | `string:$documentPath` | `AlfrescoDocument` |  `AlfrescoObjectNotFoundException`
**getDocumentContent** | Renvoie le contenu binaire d'un document Alfresco en passant son ID | `string:$documentId` | Binary Content | 
**delete** | Supprimez le document ou le dossier Alfresco avec l'ID transmis | `string:$objectId` | `boolean` |  `AlfrescoObjectNotFoundException`
**copy** | Copie le document ou le dossier Alfresco avec l'ID transmis dans le dossier avec l'ID transmis. Renvoie le nouvel objet. | `string:$objectId`<br>`string:$folderId` |   `AlfrescoObject` | `AlfrescoObjectNotFoundException`
**copyByPath** | Copie le document ou le dossier Alfresco avec l'ID transmis dans le dossier avec le chemin transmis (en commençant par le chemin de base). Renvoie le nouvel objet. | `string:$objectId` <br>`string:$folderPath` | `AlfrescoObject` |  `AlfrescoObjectNotFoundException`<br>`AlfrescoObjectAlreadyExistsException`
**move** | Déplacez le document ou le dossier Alfresco avec l'ID transmis à l'intérieur du dossier avec l'ID transmis. Renvoie le nouvel objet. | `string:$objectId` <br> `string:$folderId` | `AlfrescoObject`   |`AlfrescoObjectNotFoundException`<br>`AlfrescoObjectAlreadyExistsException`
**moveByPath** | Déplacez le document ou le dossier Alfresco avec l'ID transmis dans le dossier avec le chemin transmis (en commençant par le chemin de base). Renvoie le nouvel objet. | `string:$objectId`<br>`string:$folderPath` | `AlfrescoObject`  |  `AlfrescoObjectNotFoundException`<br>`AlfrescoObjectAlreadyExistsException`
**rename** | Renommez le document ou le dossier Alfresco avec l'ID transmis sous un nouveau nom. Renvoie le nouvel objet. | `string:$objectId`<br>`string:$newName` | `AlfrescoObject`  |  `AlfrescoObjectNotFoundException`<br>`AlfrescoObjectAlreadyExistsException`
**createDocument** | Créez un nouveau document dans Alfresco à partir du contenu binaire du dossier parent avec l'ID transmis | `string:$parentId`<br>`string:$filename`<br>`string:$filecontent` | `AlfrescoObject`  |  `AlfrescoObjectNotFoundException`<br>`AlfrescoObjectAlreadyExistsException`
**createDocumentByPath** | Créez un nouveau document dans Alfresco à partir du contenu binaire du dossier parent avec le chemin transmis (à partir du chemin de base)| `string:$parentPath`<br>`string:$filename`<br>`string:$filecontent` | `AlfrescoObject`  |  `AlfrescoObjectNotFoundException`<br>`AlfrescoObjectAlreadyExistsException`
**upload** | Charger un document dans Alfresco à partir d'un objet `UploadedFile` ou un tableau de ceux-ci. Généralement utilisé à partir d'un contrôleur Laravel, collectant les fichiers de requête provenant d'un formulaire en plusieurs parties | `string:$parentId`<br>`UploadedFile-UploadedFile[]:$documents`  |  `AlfrescoDocument` ou `string` en cas d'erreur
**getSites** | Renvoie tous les sites Alfresco (en tant qu'objets AlfrescoFolder)|   |  `AlfrescoFolder[]`
**search** | Rechercher des documents contenant le texte transmis dans le nom ou le contenu du dossier avec l'ID transmis ou la racine| `string:$query`<br>`string:$folderId=null`<br>`boolean:$recursive:false`  |  `AlfrescoObject[]` | `AlfrescoObjectNotFoundException`
**searchByPath** | Rechercher des documents contenant le texte transmis dans le nom ou le contenu du dossier avec le chemin transmis (à partir du dossier racine ou du chemin de base si défini) | `string:$query`<br>`string:$folderPath=null`<br>`boolean:$recursive:false`  |  `AlfrescoObject[]` | `AlfrescoObjectNotFoundException`



<a name="explorador"></a>
## Explorador d'arxius
Si nous activons le paramètre :
```
ALFRESCO_DEBUG = true 
```
dans les archives `.env`, nous pouvons y accéder *file-explorer* à l'itinéraire: 
`/souidev/alfresco/explorer`

> Aquesta funcionalitat requereixen el paquet **web-components**: <br><br>[https://github.com/souidev/web-components](https://github.com/souidev/web-components)<br><br>És una ruta securitzada i només s'hi podrà accedir si habilitem l'autenticació a la nostra aplicació Laravel.



