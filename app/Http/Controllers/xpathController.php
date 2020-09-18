<?php

namespace App\Http\Controllers;

use App\prog_test;
use Illuminate\Http\Request;

class xpathController extends Controller
{
    public function getXpath(){
        //inisiasi dom
        $file = "https://www.antaranews.com/indeks";
        $doc = new \DOMDocument();
        $internalErrors = libxml_use_internal_errors(true);
        $doc->loadHTMLFile($file);
        libxml_use_internal_errors($internalErrors);
        //inisiasi xpath
        $xpath = new \DOMXPath($doc);
        $elements = $xpath->query(".//div[@class='mega-menu-detail']");


        if (!is_null($elements)) {
            //loop berita yang didapatkan
            foreach ($elements as $element) {
                $newdom = new \DOMDocument();
                $newdom->appendChild($newdom->importNode($element, true));
                $xpath = new \DOMXPath($newdom);
                //mendapatkan title
                $title = trim($xpath->query(".//h4[@class='entry-title']")->item(0)->nodeValue);
                //mendapatkan date
                $date = trim($xpath->query(".//p[@class='simple-share']")->item(0)->nodeValue);
                $date = strtotime($date);
                //mendapatkan url
                $url = trim($xpath->query(".//h4[@class='entry-title']/a[contains(@href,'com')]/@href")->item(0)->nodeValue);

                $file2 = "$url";
                //inisiasi dom
                $doc2 = new \DOMDocument();
                $internalErrors2 = libxml_use_internal_errors(true);
                $doc2->loadHTMLFile($file2);
                libxml_use_internal_errors($internalErrors2);
                //inisiasi xpath
                $xpath2 = new \DOMXPath($doc2);
                $elements2 = $xpath2->query(".//article[@class='post-wrapper clearfix']");

                if (!is_null($elements2)) {
                    //loop berita yang didapatkan
                    foreach ($elements2 as $element) {
                        $newdom = new \DOMDocument();
                        $newdom->appendChild($newdom->importNode($element, true));
                        $xpath = new \DOMXPath($newdom);
                        //mendapatkan desckripsi berdasarkan url
                        $desc = trim($xpath->query(".//div[@class='post-content clearfix']")->item(0)->nodeValue);
                    }
                }
                //memasukkan data yang sudah didapat kedalam array
                $arr[] = array(
                    'title' => $title,
                    'date' => $date,
                    'url' => $url,
                    'desc' => $desc
                );
                //input database
                foreach ($arr as $item){
                    $artikel = prog_test::create([
                        'title' => $item['title'],
                        'url' => $item['url'],
                        'article_ts' => $item['date'],
                        'content' => $item['desc']
                    ]);
                    $artikel->save();
                }
                $artikel = prog_test::all();
                $countArtikel = prog_test::count();
                return redirect('/')->with('artikel',$artikel)->with('count',$countArtikel);
            }
        }
    }
}
