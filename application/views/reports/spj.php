<html>
    <table face="monospace" border="0" cellpadding="0" cellspacing="0" style="width:8.17in; margin-left:.1in; font-size:9pt; font-face:'Courier New';">
        <thead>
            <tr>
                <td colspan="5" style="border-bottom:3px double #000">
                    <h2 style="margin:0px">NEW ATLAS TAXI</h2>
                    <h2 style="margin:0px">SURAT PERINTAH JALAN</h2>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width:20%">Tanggal</td>
                <td style="width:2%">:</td>
                <td style="width:26%"><?= isset($spj->T_SpjDate) ? date('d-m-Y', strtotime($spj->T_SpjDate)) : '00-00-0000' ?></td>
                <td style="width:5%"></td>
                <td style="width:20%">No. SPJ</td>
                <td style="width:2%">:</td>
                <td style="width:25%"><?= isset($spj->T_SpjNumber) ? $spj->T_SpjNumber : '-' ?></td>
            </tr>
            <tr>
                <td>No. Lambung</td>
                <td>:</td>
                <td><?= isset($spj->M_FleetCode) ? $spj->M_FleetCode : '&nbsp;' ?></td>
                <td>&nbsp;</td>
                <td>Jenis Mobil</td>
                <td>:</td>
                <td><?= isset($spj->M_FleetVehicleType) ? $spj->M_FleetVehicleType : '&nbsp;' ?></td>
            </tr>
            <tr>
                <td>No. KTA</td>
                <td>:</td>
                <td><?= isset($spj->M_DriversCode) ? $spj->M_DriversCode : '&nbsp;' ?></td>
                <td>&nbsp;</td>
                <td>Nama Pengemudi</td>
                <td>:</td>
                <td><?= isset($spj->M_DriversName) ? $spj->M_DriversName : '&nbsp;' ?></td>
            </tr>
            <tr>
                <td>Jam Berangkat</td>
                <td>:</td>
                <td><?= isset($spj->T_SpjTime) ? substr($spj->T_SpjTime, 0, 5) : '00:00' ?></td>
                <td>&nbsp;</td>
                <td>Batas Jam Pulang</td>
                <td>:</td>
                <td><?= isset($spj->T_SpjTime) ? date('H:i', strtotime($spj->T_SpjDate . ' ' . $spj->T_SpjTime) + ($spj->M_FleetHour * 3600)) : '00:00' ?></td>
            </tr>
            <tr>
                <td>KM. Spido Berangkat</td>
                <td>:</td>
                <td><?= isset($spj->T_SpjStartKM) ? $spj->T_SpjStartKM : '0' ?></td>
                <td>&nbsp;</td>
                <td>Jml Angsuran</td>
                <td>:</td>
                <td>0</td>
            </tr>
            <tr>
                <td colspan="7" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Target Setoran</td>
                <td>:</td>
                <td align="right"><?= isset($spj->T_SpjPay) ? number_format($spj->T_SpjPay,0,',','.') : '0' ?></td>
                <td>&nbsp;</td>
                <td>Catatan</td>
                <td>:</td>
                <td><?= isset($spj->T_SpjNote) ? $spj->T_SpjNote : '-' ?></td>
            </tr>
            <tr>
                <td>Iuran LAKA</td>
                <td>:</td>
                <td align="right"><?= isset($spj->T_SpjLaka) ? number_format($spj->T_SpjLaka,0,',','.') : number_format(3000,0,',','.') ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="7" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Over Time</td>
                <td>:</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td>KM. Pulang</td>
                <td>:</td>
                <td align="right">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
                <td colspan="4" style="font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Jml Pendapatan</td>
                <td>:</td>
                <td align="right">&nbsp;</td>
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
                <td>Potongan Jam</td>
                <td>:</td>
                <td align="right">0</td>
                <td>&nbsp;</td>
                <td>Keterangan</td>
                <td>:</td>
                <td><?= isset($spj->T_SpjPotonganNote) ? $spj->T_SpjPotonganNote : '-' ?></td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
                <td colspan="4" style="font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Potongan Lain2</td>
                <td>:</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
                <td colspan="4" style="font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Jml. Potongan</td>
                <td>:</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td>Disetujui</td>
                <td>:</td>
                <td><?= isset($spj->T_SpjSignature) ? '( ' . $spj->T_SpjSignature . ' )' : '( ........... )' ?></td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
                <td colspan="4" style="font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Jml. Harus Disetor</td>
                <td>:</td>
                <td align="right"><?= isset($spj->T_SpjTotal) ? number_format($spj->T_SpjTotal, 0,',','.') : '0' ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
                <td colspan="4" style="font-size:5px">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Kurang/Belum Setor</td>
                <td>:</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">
                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                        <tr>
                            <td style="width:40%; border-top:solid 1px #000">Pengemudi</td>
                            <td style="width:20%">&nbsp;</td>
                            <td style="width:40%; border-top:solid 1px #000">Security</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="7" style="border-bottom:solid 1px #000; font-size:5px">&nbsp;</td>
            </tr>
            <?php
            $x = $this->session->userdata('atlas');
            ?>
            <tr>
                <td><?= date('d-m-Y H:i:s') ?> </td>
                <td colspan="6"><?= $x['un'] . '&nbsp;-&nbsp;' . $x['nm'] ?></td>
            </tr>
        </tbody>
    </table>
</html>
