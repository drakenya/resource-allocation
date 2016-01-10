<?php

namespace Drakenya\ResAll\Allocators;

class VirtualMachine extends AllocatorAbstract {
    /**
     * Actually create a new resource
     *
     * @return array Details about new resource
     */
    public function allocate() {
        $base_vm_name = $this->settings['base_vm_name'];
        $vm_name = uniqid('vm_');
        $vm_path = str_replace(' ', '\\ ', $this->settings['vm_path'] . $vm_name . '/' . $vm_name . '.vbox');

        $commands = [
            'VBoxManage clonevm ' . $base_vm_name . ' --name ' . $vm_name,
            'VBoxManage registervm ' . $vm_path,
        ];

        foreach ($commands as $cmd) {
            exec($cmd);
        }

        return [
            'name' => $vm_name,
        ];
    }

    /**
     * Remove existing resource from the pool/system
     *
     * @param array $data
     */
    public function deallocate($data) {
        $vm_name = $data['internal_data']['name'];

        $commands = [
            'VBoxManage unregistervm ' . $vm_name . ' --delete',
        ];

        foreach ($commands as $cmd) {
            exec($cmd);
        }
    }
}