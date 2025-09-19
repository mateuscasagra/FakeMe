<?php 
namespace ApiClient\Webhook\Extractors;

interface Extractor {
    public function extract();
    public function phoneFormat();
}