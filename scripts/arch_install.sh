#!/bin/sh

MICROSD=/dev/sdd

echo "Copiando Arch Linux sobre ${MICROSD}"

sed -e 's/\s*\([\+0-9a-zA-Z]*\).*/\1/' << EOF | fdisk ${MICROSD}
    o       # Se limpia la tabla de particiones
    n       # Se crea una nueva partición
    p       #  primaria
    1       #  número uno
            #  por defecto al principio del disco
    +200M   #  y con un tamaño de 200MiB
    t       # Se cambia el tipo de la partición
    c       #  a W95 FAT32 (LBA)
    n       # Se crea otra partición
    p       #  primaria
    2       #  número dos
            #  a continuación de la primera
            #  y que ocupe todo el disco
    w       # Se escribe la tabla de particiones
EOF

# Se crean carpetas para montar las particiones 1 (boot) y 2 (root)
mkdir -p boot root

# Y se formatean los sistemas de ficheros
mkfs.vfat ${MICROSD}1
mkfs.ext4 ${MICROSD}2

# Se montan las particiones
mount ${MICROSD}1 boot
mount ${MICROSD}2 root

# Y se extrae el tarball a root
bsdtar -xpf ArchLinuxARM-rpi-aarch64-latest.tar.gz -C root

# Se mueve el directorio boot a su partición
mv root/boot/* boot

# Se realiza una modificación en el fstab para adaptarlo a 64 bits
sed -i 's/mmcblk0/mmcblk1/g' root/etc/fstab

# Se escriben los datos a la SD y se desmontan las carpetas
sync
umount boot root
