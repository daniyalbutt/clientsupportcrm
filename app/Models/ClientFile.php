<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class ClientFile extends Model
{
    use HasFactory;
    protected $table = 'client_files';
    protected $fillable = ['path', 'name', 'status', 'task_id', 'user_id', 'user_check', 'production_check', 'message_id'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
    
    public function get_extension(){
        $path = $this->path;
        $temp = explode('.',$path);
        $extension = end($temp);
        return $extension;
    }

    public function generatePresignedUrl()
    {
        $filePath = $this->path;
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
