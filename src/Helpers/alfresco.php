<?php
if (! function_exists('alfresco')) {
	function alfresco($options=null){
		return new \Souidev\AlfrescoLaravel\Models\AlfrescoService($options);
	}
}
