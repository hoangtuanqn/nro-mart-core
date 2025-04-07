<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UploadHelper
{
    /**
     * Đảm bảo thư mục tồn tại với quyền 0755
     *
     * @param string $path Đường dẫn thư mục
     * @return string Đường dẫn đầy đủ của thư mục
     */
    public static function ensureDirectoryExists(string $path): string
    {
        $fullPath = Storage::path($path);

        if (!file_exists($fullPath)) {
            // Lưu umask hiện tại
            $oldUmask = umask(0);

            // Tạo thư mục với quyền 0755
            mkdir($fullPath, 0755, true);

            // Khôi phục umask ban đầu
            umask($oldUmask);
        }

        return $fullPath;
    }

    /**
     * Upload một file và trả về URL công khai
     *
     * @param UploadedFile $file File cần upload
     * @param string $directory Thư mục lưu trữ
     * @param string|null $filename Tên file tùy chọn
     * @param bool $preserveFilename Có giữ nguyên tên file gốc không
     * @return string URL công khai của file
     */
    public static function upload(UploadedFile $file, string $directory, ?string $filename = null, bool $preserveFilename = false): string
    {
        try {
            // Đảm bảo thư mục tồn tại với quyền 0755
            self::ensureDirectoryExists('public/' . $directory);

            // Tạo tên file nếu không được chỉ định
            if (!$filename) {
                if ($preserveFilename) {
                    $filename = $file->getClientOriginalName();
                } else {
                    $filename = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                }
            }

            // Upload file
            $path = $file->storeAs('public/' . $directory, $filename);

            return Storage::url($path);
        } catch (\Exception $e) {
            Log::error('Error uploading file: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Upload nhiều file và trả về mảng URL công khai
     *
     * @param array $files Mảng các file cần upload
     * @param string $directory Thư mục lưu trữ
     * @return array Mảng URL công khai của các file
     */
    public static function uploadMultiple(array $files, string $directory): array
    {
        $urls = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $urls[] = self::upload($file, $directory);
            }
        }

        return $urls;
    }

    /**
     * Xóa file dựa trên URL công khai
     *
     * @param string $url URL công khai của file
     * @return bool Kết quả xóa file
     */
    public static function deleteByUrl(string $url): bool
    {
        try {
            $path = str_replace('/storage', 'public', $url);
            return Storage::delete($path);
        } catch (\Exception $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            return false;
        }
    }
}