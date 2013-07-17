<html>
    <table face="monospace" border="0" cellpadding="0" cellspacing="0" style="width:8.17in; margin-left:.1in; font-size:9pt; font-face:'Courier New';">
        <thead>
            <tr>
                <td colspan="7" style="border-bottom:3px double #000">
                    <h2 style="margin:0px">NEW ATLAS TAXI</h2>
                    <h2 style="margin:0px">BUKTI PEMBAYARAN KS</h2>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width:20%">Tanggal</td>
                <td style="width:2%">:</td>
                <td style="width:26%"><?= isset($ks->L_PayLogDate) ? date('d-m-Y', strtotime($ks->L_PayLogDate)) : '00-00-0000' ?></td>
                <td style="width:5%"></td>
                <td style="width:20%">No. Bukti</td>
                <td style="width:2%">:</td>
                <td style="width:25%"><?= isset($ks->L_PayLogNumber) ? $ks->L_PayLogNumber : '-' ?></td>
            </tr>
            <tr>
                <td>No. KTA</td>
                <td>:</td>
                <td><?= isset($ks->M_DriversCode) ? $ks->M_DriversCode : '&nbsp;' ?></td>
                <td>&nbsp;</td>
                <td>Nama Pengemudi</td>
                <td>:</td>
                <td><?= isset($ks->M_DriversName) ? $ks->M_DriversName : '&nbsp;' ?></td>
            </tr>
            <tr>
                <td colspan="7" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Jumlah KS</td>
                <td>:</td>
                <td align="right"><?= isset($ks->L_PayLogAmount) ? number_format($ks->L_PayLogAmount + $ks->L_PayLogBalance,0,',','.') : number_format(0,0,',','.') ?></td>
                <td>&nbsp;</td>
                <td>Catatan</td>
                <td>:</td>
                <td><?= isset($ks->L_PayLogNote) ? $ks->L_PayLogNote : '-' ?></td>
            </tr>
            <tr>
                <td>Jumlah Bayar</td>
                <td>:</td>
                <td align="right"><?= isset($ks->L_PayLogAmount) ? number_format($ks->L_PayLogAmount,0,',','.') : number_format(0,0,',','.') ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
                <td colspan="4" style="font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Saldo KS</td>
                <td>:</td>
                <td align="right"><?= isset($ks->L_PayLogBalance) ? number_format($ks->L_PayLogBalance,0,',','.') : number_format(0,0,',','.') ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right">&nbsp;</td>
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
