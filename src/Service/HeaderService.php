<?php
/**
 * Created by PhpStorm.
 * User: dbollard
 * Date: 09/08/2018
 * Time: 19:31
 */

namespace App\Service;


class HeaderService
{
    public function setTitleHeader($header)
    {

        $title = $header->getBilling()->getAlias() . '_' .
            $header->getApplication()->getClient()->getAlias() . '_' .
            $header->getCreatedOn()->format('ymd') . '_' .
            $header->getApplication()->getAlias();
        if ($header->getApplicationVersion() !== '') {
            /*            $title = $title . '';
                    } else {*/
            $title = $title . '_' . $header->getApplicationVersion();
        }
        return $title;
    }

    public function getTotalDays($header)
    {

        $res = 0;

        foreach ($header->getDetails() as $detail) {
            $res = $res + $detail->getCalculatedDays();
        }

        return $res;
    }

    public function getTotalPrice($header)
    {

        $res = 0;

        foreach ($header->getDetails() as $detail) {
            $res = $res + $detail->getPrice();
        }

        return $res;
    }

    public function getReducedString($string, $maxlen = NULL)
    {

        $maxLengthToShow = ($maxlen == null) ? 80 : $maxlen;
        $endingString = " (...)";
        $lengthShown = $maxLengthToShow - strlen($endingString);

        if (strlen($string) > $maxLengthToShow) {
            $res = substr($string, 0, $lengthShown) . $endingString;
        } else {
            $res = $string;
        }

        return $res;
    }

    public function getStatus($header)
    {
        if ($header->getBilledOn() != null) {
            $res = 8;
        } else {
            if ($header->getDeliveredOn() != null) {
                $res = 7;
            } else {
                if ($header->getRefusedOn() != null) {
                    $res = 6;
                } else {
                    if ($header->getAgreedOn() != null) {
                        $res = 5;
                    } else {
                        if ($header->getSentOn() != null) {
                            $res = 4;
                        } else {
                            if ($header->getDeletedOn() != null) {
                                $res = 3;
                            } else {
                                if ($header->getUpdatedOn() != null) {
                                    $res = 2;
                                } else {
                                    $res = 1;
                                }
                            }
                        }
                    }

                }
            }
        }

        return $res;
    }
}