<?php

namespace ICN;

class Upload
{
    /**
     * Get number of valid uploades
     * @param $uploadsName
     * @return int
     */
    public static function countValidUploads($uploadsName)
    {
        $validNum = 0;
        foreach ( (array) $uploadsName as $name) {
            if ( strlen($name) )
                $validNum++;
        }

        return $validNum;
    }

    /**
     * Upload the specified files to wordpress
     * @param $filesArr
     * @return array
     */
    public static function uploadFilesToWordpress($filesArr)
    {
        $results = [];
        foreach ($filesArr['name'] as $key => $value) {
            if ( $filesArr['name'][$key] ) {
                $file = array(
                    'name'     => $filesArr['name'][$key],
                    'type'     => $filesArr['type'][$key],
                    'tmp_name' => $filesArr['tmp_name'][$key],
                    'error'    => $filesArr['error'][$key],
                    'size'     => $filesArr['size'][$key]
                );

                $results[] = wp_handle_upload($file, ['test_form' => false]);
            }
        }

        return $results;
    }

    /**
     * Fire an email containing the attachments
     * @param $from
     * @param $to
     * @param $subject
     * @param $message
     * @param $attachments
     * @param string $bcc
     * @return bool
     */
    public static function fireAttachmentEmail($from, $to, $subject, $message, $attachments, $bcc = '')
    {
        $headers[] = 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $headers[] = "From: $from" . "\r\n";

        if ( strlen($bcc) )
            $headers[] = "Bcc: $bcc";

        return wp_mail($to, $subject, $message, $headers, $attachments);
    }
}