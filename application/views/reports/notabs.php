<html>
    <table face="monospace" border="0" cellpadding="0" cellspacing="0" style="width:8.17in; margin-left:.1in; font-size:9pt; font-face:'Courier New';">
        <thead>
            <tr>
                <td colspan="7" style="border-bottom:3px double #000">
                    <h2 style="margin:0px">NEW ATLAS TAXI</h2>
                    <h2 style="margin:0px">BUKTI PEMBAYARAN BS</h2>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width:20%">Tanggal</td>
                <td style="width:2%">:</td>
                <td style="width:26%"><?= isset($bs->L_PayLogDate) ? date('d-m-Y', strtotime($bs->L_PayLogDate)) : '00-00-0000' ?></td>
                <td style="width:5%"></td>
                <td style="width:20%">No. Bukti</td>
                <td style="width:2%">:</td>
                <td style="width:25%"><?= isset($bs->L_PayLogNumber) ? $bs->L_PayLogNumber : '-' ?></td>
            </tr>
            <tr>
                <td>No. KTA</td>
                <td>:</td>
                <td><?= isset($bs->M_DriversCode) ? $bs->M_DriversCode : '&nbsp;' ?></td>
                <td>&nbsp;</td>
                <td>Nama Pengemudi</td>
                <td>:</td>
                <td><?= isset($bs->M_DriversName) ? $bs->M_DriversName : '&nbsp;' ?></td>
            </tr>
            <tr>
                <td colspan="7" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Jumlah BS</td>
                <td>:</td>
                <td align="right"><?= isset($bs->L_PayLogAmount) ? number_format($bs->L_PayLogAmount + $bs->L_PayLogBalance,0,',','.') : number_format(0,0,',','.') ?></td>
                <td>&nbsp;</td>
                <td>Catatan :</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Potongan</td>
                <td>:</td>
                <td align="right"><?= isset($bs->L_PayLogDiscount) ? number_format($bs->L_PayLogDiscount,0,',','.') : number_format(0,0,',','.') ?></td>
                <td>&nbsp;</td>
                <td colspan="3" rowspan="3" valign="top"><?= isset($bs->L_PayLogNote) ? $bs->L_PayLogNote : '-' ?></td>
            </tr>
            <tr>
                <td>Jumlah Bayar</td>
                <td>:</td>
                <td align="right"><?= isset($bs->L_PayLogAmount) ? number_format($bs->L_PayLogAmount,0,',','.') : number_format(0,0,',','.') ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
                <td colspan="4" style="font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Saldo KS</td>
                <td>:</td>
                <td align="right"><?= isset($bs->L_PayLogBalance) ? number_format($bs->L_PayLogBalance,0,',','.') : number_format(0,0,',','.') ?></td>
                <td>&nbsp;</td>
            </tr>           
            
            <tr>
                <td colspan="7" style="border-bottom:3px double #000; font-size:5px">&nbsp;</td>
            </tr>
            <?php
            $x = $this->session->userdata('atlas');
            ?>
            <tr>
                <td><?= date('d-m-Y H:i:s') ?> </td>
                <td colspan="6"><?= $x['un'] . '&nbsp;-&nbsp;' . $x['nm'] ?></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td align="center" height="50" valign="top">Tanda Terima Kasir</td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td align="center"><?= '( ' . $x['nm'] . ' )' ?></td>
            </tr>
        </tbody>
    </table>
</html>
