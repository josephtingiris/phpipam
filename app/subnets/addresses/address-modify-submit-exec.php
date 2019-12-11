<?php
// exec external scripts
if(!empty($config['address_execs']) && is_array($config['address_execs'])) {
    if (!empty($action) && !empty($address['ip_addr']) && !empty($address['hostname'])) {
        foreach ($config['address_execs'] as $address_exec) {
            if (is_executable($address_exec)) {
                $address_exec_args="$action";
                $address_exec_args.=" -a ".$address['ip_addr'];
                $address_exec_args.=" -h ".$address['hostname'];

                error_log("address_exec: $address_exec" . " " . $address_exec_args);
                $address_exec_output=array();
                $address_exec_rc=99;
                exec($address_exec . " " . $address_exec_args,$address_exec_output,$address_exec_rc);

                error_log(print_r($address_exec_output,true));

                if ($address_exec_rc == 0) {
                    $Result->show("success", _("'$address_exec $address_exec_arg' successful"),false);
                } else {
                    $Result->show("danger", _("'$address_exec $address_exec_args' failed [rc=$address_exec_rc]"),false);
                }
            }
        }
    }
}
?>
