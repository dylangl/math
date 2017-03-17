<?php

namespace Dylangl\Math;


class MathCount
{
    /**
     * 二维数组排序
     * @param array $arr 需要排序的二维数组
     * @param string $keys 所根据排序的key
     * @param string $type 排序类型，desc、asc
     * @return array $new_array 排好序的结果
     */
    public static function array_sort($arr, $keys, $type = 'desc')
    {
        $key_value = $new_array = array();
        foreach ($arr as $k => $v) {
            $key_value[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($key_value);
        } else {
            arsort($key_value);
        }
        reset($key_value);
        foreach ($key_value as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }

    /**
     * EXCEL用，将列数字转换为列字母
     * @param int $pColumnIndex
     * @return mixed
     */
    public static function stringFromColumnIndex($pColumnIndex = 0)
    {
        static $_indexCache = array();
        if (!isset($_indexCache[$pColumnIndex])) {
            if ($pColumnIndex < 26) {
                $_indexCache[$pColumnIndex] = chr(65 + $pColumnIndex);
            } elseif ($pColumnIndex < 702) {
                $_indexCache[$pColumnIndex] = chr(64 + ($pColumnIndex / 26)) .
                    chr(65 + $pColumnIndex % 26);
            } else {
                $_indexCache[$pColumnIndex] = chr(64 + (($pColumnIndex - 26) / 676)) .
                    chr(65 + ((($pColumnIndex - 26) % 676) / 26)) .
                    chr(65 + $pColumnIndex % 26);
            }
        }
        return $_indexCache[$pColumnIndex];
    }

    /**
     * 获取排名
     * @param integer $score
     * @param array $scoreList
     * @return string
     */
    public static function getRank($score, $scoreList)
    {
        $allCount = count($scoreList);
        $count = 0;

        if ($allCount == 1) {
            return '1%';
        }

        foreach ($scoreList as $key => $value) {
            if ($score < $value) {
                $count++;
            }
        }

        $result = $count / ($allCount - 1) * 100;
        if ($result >= 100) {
            $result = 99;
        } else if ($result <= 0) {
            $result = 1;
        }
        return round($result, 0) . '%';
    }

    /**
     * 计算平均分
     * @param array $scoreList
     * @return int
     */
    public static function getAvg($scoreList)
    {
        if (empty($scoreList)) {
            return 0;
        }
        $sum = 0;
        foreach ($scoreList as $value) {
            $sum += $value;
        }
        $count = count($scoreList);
        $avg = round($sum / $count, 2);

        return $avg;
    }

    /**
     * 计算方差
     * @param array $scoreList
     * @return int
     */
    public static function getVariance($scoreList)
    {
        if (empty($scoreList)) {
            return 0;
        }
        $avg = self::getAvg($scoreList);
        $count = count($scoreList);
        $numerator = 0;//分子
        foreach ($scoreList as $value) {
            $numerator += pow($value - $avg, 2);    //平方
        }

        $result = round($numerator / $count, 2);
        return $result;
    }

    /**
     * 将文件转换成bass64
     * @param $file
     * @return string
     */
    public static function fileToBase64($file)
    {
        $base64_file = '';
        if (file_exists($file)) {
            $mime_type = mime_content_type($file);
            $base64_data = base64_encode(file_get_contents($file));
            $base64_file = 'data:' . $mime_type . ';base64,' . $base64_data;

            //删除文件
            unlink($file);
        }
        return $base64_file;
    }
}