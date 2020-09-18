<?php

namespace App\Http\Controllers;

use App\prog_test;
use function GuzzleHttp\Promise\all;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;

class rssController extends Controller
{
    public function getRss(){
        //inisiasi curl
        $ch = curl_init();
        //setting curl
        curl_setopt($ch, CURLOPT_URL, 'https://www.tribunnews.com/rss');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //menjalankan curl
        $hasil = curl_exec($ch);
        curl_close($ch);
        //parse curl xml
        $xml = simplexml_load_string($hasil);

        //display the data
        foreach ($xml->channel->item as $post) {
            //get title
            $title = "$post->title";
            //get url link
            $file = "$post->link";
            //membuat dom
            $doc = new \DOMDocument();
            $internalErrors = libxml_use_internal_errors(true);
            $doc->loadHTMLFile($file);
            libxml_use_internal_errors($internalErrors);
            //inisiasi xpath
            $xpath = new \DOMXPath($doc);
            //mengambil content berdasarkan xpath
            $elements = $xpath->query(".//div[@id='article_con']");
            //mengecek apakah xpath tidak kosong
            if (!is_null($elements)) {
                foreach ($elements as $element) {
                    $newdom = new \DOMDocument();
                    $newdom->appendChild($newdom->importNode($element, true));
                    $xpath = new \DOMXPath($newdom);
                    $desc = trim($xpath->query(".//div[@class='side-article txt-article']")->item(0)->nodeValue);
                }
            }
            //memasukkan kedalam array
            $arr[] = array(
                'title' => $title,
                'date' => strtotime($post->pubDate),
                'url' => $file,
                'summary' =>  $this->make_safe($post->description),
                'desc' =>  $desc
            );
        }

        //input database
        foreach ($arr as $item){
            $artikel = prog_test::create([
                'title' => $item['title'],
                'url' => $item['url'],
                'article_ts' => $item['date'],
                'content' => $item['desc'],
                'summary' => $item['summary']
            ]);
            $artikel->save();
        }
        //get all data from table prog_test
        $artikel = prog_test::all();
        //count data from table prog_test
        $countArtikel = prog_test::count();
        return redirect('/')->with('artikel',$artikel)->with('count',$countArtikel);
    }

    //replace string
    public function make_safe($string) {
        $string = preg_replace('#<!\[CDATA\[.*?\]\]>#s', '', $string);
        $string = strip_tags($string);
        // Instead, use this set of replacements in older versions of PHP.
        $string = str_replace('<', '&lt;', $string);
        $string = str_replace('>', '&gt;', $string);
        $string = str_replace('(', '&#40;', $string);
        $string = str_replace(')', '&#41;', $string);
        $string = str_replace('"', '&quot;', $string);
        $string = str_replace('\'', '&#039;', $string);
        return $string;
    }
}
