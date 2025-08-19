<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class Issue extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_no', 'brand_id', 'user_id', 'client_id', 'generated_by', 'description', 'issue', 'level', 'status','file_path','filename'];
    protected $casts = ['issue' => 'array'];

    public function get_extension(){
        $path = $this->file_path;
        $temp = explode('.',$path);
        $extension = end($temp);
        return $extension;
    }

    public function brands(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket_user(){
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function generatePresignedUrl()
    {
        $filePath = $this->file_path;
        $s3Client = new S3Client([
            'version'     => 'latest',
            'region'      => config('filesystems.disks.wasabi.region'),
            'credentials' => [
                'key'    => config('filesystems.disks.wasabi.key'),
                'secret' => config('filesystems.disks.wasabi.secret'),
            ],
            'endpoint' => config('filesystems.disks.wasabi.endpoint'),
        ]);

        $command = $s3Client->getCommand('GetObject', [
            'Bucket' => config('filesystems.disks.wasabi.bucket'),
            'Key'    => $filePath,
            'ACL'    => 'public-read',
        ]);

        $request = $s3Client->createPresignedRequest($command, '+6 days 23 hours');

        return (string) $request->getUri();
    }
}
