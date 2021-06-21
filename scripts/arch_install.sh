[https://superuser.com/questions/332252/how-to-create-and-format-a-partition-using-a-bash-script]

fdisk /dev/sdX
 - o
 - p
 - n p 1 <ENTER> +200M
 - t c
 - n p 2 <ENTER> <ENTER>
 - w

mkfs.vfat /dev/sdX1
mkdir boot
mount /dev/sdX1 boot

mkfs.ext4 /dev/sdX2
mkdir root
mount /dev/sdX2 root

wget http://os.archlinuxarm.org/os/ArchLinuxARM-rpi-aarch64-latest.tar.gz
bsdtar -xpf ArchLinuxARM-rpi-aarch64-latest.tar.gz -C root
sync

mv root/boot/* boot

sed -i 's/mmcblk0/mmcblk1/g' root/etc/fstab

umount boot root

pacman-key --init
pacman-key --populate archlinuxarm