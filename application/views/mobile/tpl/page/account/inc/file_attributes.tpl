[{$oOrderFile->getFileSize()|oxfilesize}]
                           
[{if $oOrderFile->oxorderfiles__oxdownloadcount->value == 0 && $oOrderFile->getValidUntil() != "0000-00-00 00:00"  }]
    [{if $oOrderFile->oxorderfiles__oxlinkexpirationtime->value || $oOrderFile->oxorderfiles__oxdownloadxpirationtime->value }]
        [{ oxmultilang ident="START_DOWNLOADING_UNTIL" }] [{$oOrderFile->getValidUntil()}]
    [{/if}]
    [{if $oOrderFile->oxorderfiles__oxmaxdownloadcount->value != 0 }]
        [{ oxmultilang ident="LEFT_DOWNLOADS" }] : [{ $oOrderFile->getLeftDownloadCount() }]
    [{/if}]
[{else}]
    [{if $oOrderFile->getValidUntil() != "0000-00-00 00:00"  }]
        [{if $oOrderFile->oxorderfiles__oxlinkexpirationtime->value || $oOrderFile->oxorderfiles__oxdownloadxpirationtime->value }]
            [{ oxmultilang ident="LINK_VALID_UNTIL" }] : [{ $oOrderFile->getValidUntil() }].
        [{/if}]
    [{/if}]
    [{if $oOrderFile->oxorderfiles__oxmaxdownloadcount->value != 0 }]
        [{ oxmultilang ident="LEFT_DOWNLOADS" }] : [{ $oOrderFile->getLeftDownloadCount() }]
    [{/if}]
[{/if}]