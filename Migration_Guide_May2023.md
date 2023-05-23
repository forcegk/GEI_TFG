# Migration guide for GEI_TFG restructuring at May 2023
Due to internationalization efforts to make the repository more accessible to English speakers, the repository is being restructured.

Due to this, when "git pull"ing the latest updates from the final hardware, it will certainly break. For that reason, a migration guide is detailed below.

This guide has only to be followed on the master node.

```bash
# Get superuser privileges
su -

# Stop dashboard daemon
systemctl stop clupiter_dashboard.service

# Erase previous installation
rm -rf /clupiter_dashboard/GEI_TFG

# Change to mpiuser
su - mpiuser

# Download repo for app deployment
cd /clupiter_dashboard
git clone https://github.com/forcegk/GEI_TFG.git
cd GEI_TFG

# Create symlinks for backwards compatibility
mkdir app
ln -sf /clupiter_dashboard/GEI_TFG/src/dashboard /clupiter_dashboard/GEI_TFG/app/node

# If all steps were successful, we should be able to deploy the server
cd app/node
npm install --only=production
cat www/video/vid_1.mp4__* > www/video/vid_1.mp4

# Exit from mpiuser to return to superuser account
exit

# And start the daemon again
systemctl start clupiter_dashboard.service

# Finally exit in the way you like the most.
exit

# Maybe rebooting the cluster just to ensure everything is working fine is a good idea...?
#  (Everything should work just fine anyway)
```
