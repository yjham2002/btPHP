<?php
/**
 * Created by PhpStorm.
 * User: 전세호
 * Date: 2018-05-13
 * Time: 오후 10:21
 */
?>
<!--<div class="pageNumber pagination" align="right">-->
<!--    <ul class="pagination">-->
<!--        --><?//
//            if($obj->isPrevBlock()){
//                echo '<li class="page-link"><a class="jPage" page="1"></a></li>';
//                echo '<li class="page-link"><a class="jPage" page="' . ($obj->startBlock - 1) . '"></a><li>';
//            }
//
//            for($i=$obj->startBlock; $i<=$obj->endBlock; $i++){
//                if( $obj->req["page"] == $i ) echo '<li class="active page-link"><a href="#">'.$i.'</a></li>' ;
//                else echo '<li class="page-link"><a href="#" class="jPage" page="'.$i.'">'.$i.'</a></li>' ;
//            }
//
//            if($obj->isNextBlock()){
//                echo '<li class="page-link"><a class="jPage" page="' . ($obj->endBlock + 1) . '" alt="다음"></li>';
//                echo '<li><a class="jPage" page="' . ($obj->endPage) . '" src="/admin/inc/images/paging_last.gif" alt="마지막페이지"></li>';
//            }
//        ?>
<!--    </ul>-->
<!--</div>-->


<nav aria-label="...">
    <ul class="pagination justify-content-end">
        <?
            if($obj->isPrevBlock())
                echo '<li class="page-item"><a class="page-link jPage" page="' . ($obj->startBlock - 1) . '">Prev</a></li>';

            for($i=$obj->startBlock; $i<=$obj->endBlock; $i++){
                if( $obj->req["page"] == $i ) echo '<li class="page-item active"><span class="page-link">' . $i . '<span class="sr-only">(current)</span></span></li>';
                else echo '<li class="page-item"><a class="page-link jPage" page="' . $i . '">' . $i . '</a></li>';
            }

            if($obj->isNextBlock())
                echo '<li class="page-item"><a class="page-link jPage" page="' . ($obj->endBlock + 1) . '">Next</a></li>';
        ?>
    </ul>
</nav>