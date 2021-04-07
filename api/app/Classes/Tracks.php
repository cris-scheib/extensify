<?php

namespace App\Classes;
use App\Models\Track;
use App\Models\Artist;
use App\Classes\Spotify\Tracks as SpotifyTracks;
use Illuminate\Support\Facades\DB;

class Tracks
{
    private $trackModel;
    private $artistModel;

    public function __construct(Track $trackModel, Artist $artistModel)
    {
         $this->trackModel = $trackModel;
         $this->artistModel = $artistModel;
    }

    public function getTracks()
    {
        $spotifyTracks = new SpotifyTracks(); 
        $data = $spotifyTracks->getTracks();
        DB::beginTransaction();
        try { 

           foreach($data->items as $spotifyTrack){
               
               $artist = $this->artistModel
                ->where('spotify_id', $spotifyTrack->artists[0]->id)
                ->first();
                if($artist === null){
                    $artist = $this->artistModel->create([
                        'name' => $spotifyTrack->artists[0]->name, 
                        'spotify_id' =>  $spotifyTrack->artists[0]->id,
                        'image' => null,
                    ]);
                }
                $track = $this->trackModel
                 ->where('spotify_id', $spotifyTrack->id)
                 ->first(); 


                 if($track === null){
                     $track = $this->trackModel->create([
                        'name' => $spotifyTrack->name, 
                        'spotify_id' =>  $spotifyTrack->id, 
                        'artist_id' => $artist->id, 
                     ]);
                 }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }
    
}