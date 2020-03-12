<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DomainConfig {

	public static function getMyDomain() {
	    $domainName = $_SERVER['HTTP_HOST'];
	    return $domainName;
	}
	public static function getDomainPublicKey($domain) {
		foreach (DOMAINS as $domainName => $domainPublicKey) {
			if($domainName==$domain) {
				return $domainPublicKey;
			}
		}
		return 0;
	}


}
