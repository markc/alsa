AlsaBuildConfig
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

See also
--------

-   [ALSA](/ALSA "ALSA")
-   [AlsaBuild](/AlsaBuild "AlsaBuild")
-   [AlsaKernel](/AlsaKernel "AlsaKernel")
-   [AlsaRemove](/AlsaRemove "AlsaRemove")

Make config
-----------

` `

    #
    # Automatically generated make config: don't edit
    #
    CONFIG_X86=y
    CONFIG_ISA=y
    # CONFIG_SBUS is not set
    CONFIG_UID16=y

    #
    # Code maturity level options
    #
    CONFIG_EXPERIMENTAL=y

    #
    # Loadable module support
    #
    CONFIG_MODULES=y
    CONFIG_MODVERSIONS=y
    CONFIG_KMOD=y

    #
    # Processor type and features
    #
    # CONFIG_M386 is not set
    # CONFIG_M486 is not set
    # CONFIG_M586 is not set
    # CONFIG_M586TSC is not set
    # CONFIG_M586MMX is not set
    CONFIG_M686=y
    # CONFIG_MPENTIUMIII is not set
    # CONFIG_MPENTIUM4 is not set
    # CONFIG_MK6 is not set
    # CONFIG_MK7 is not set
    # CONFIG_MELAN is not set
    # CONFIG_MCRUSOE is not set
    # CONFIG_MWINCHIPC6 is not set
    # CONFIG_MWINCHIP2 is not set
    # CONFIG_MWINCHIP3D is not set
    # CONFIG_MCYRIXIII is not set
    CONFIG_X86_WP_WORKS_OK=y
    CONFIG_X86_INVLPG=y
    CONFIG_X86_CMPXCHG=y
    CONFIG_X86_XADD=y
    CONFIG_X86_BSWAP=y
    CONFIG_X86_POPAD_OK=y
    # CONFIG_RWSEM_GENERIC_SPINLOCK is not set
    CONFIG_RWSEM_XCHGADD_ALGORITHM=y
    CONFIG_X86_L1_CACHE_SHIFT=5
    CONFIG_X86_TSC=y
    CONFIG_X86_GOOD_APIC=y
    CONFIG_X86_PGE=y
    CONFIG_X86_USE_PPRO_CHECKSUM=y
    CONFIG_X86_PPRO_FENCE=y
    # CONFIG_X86_MCE is not set
    # CONFIG_TOSHIBA is not set
    # CONFIG_I8K is not set
    # CONFIG_MICROCODE is not set
    # CONFIG_X86_MSR is not set
    # CONFIG_X86_CPUID is not set
    CONFIG_NOHIGHMEM=y
    # CONFIG_HIGHMEM4G is not set
    # CONFIG_HIGHMEM64G is not set
    # CONFIG_MATH_EMULATION is not set
    CONFIG_MTRR=y
    # CONFIG_SMP is not set
    CONFIG_PREEMPT=y
    # CONFIG_X86_UP_APIC is not set
    CONFIG_HAVE_DEC_LOCK=y

    #
    # General setup
    #
    CONFIG_NET=y
    CONFIG_PCI=y
    # CONFIG_PCI_GOBIOS is not set
    # CONFIG_PCI_GODIRECT is not set
    CONFIG_PCI_GOANY=y
    CONFIG_PCI_BIOS=y
    CONFIG_PCI_DIRECT=y
    CONFIG_PCI_NAMES=y
    # CONFIG_EISA is not set
    # CONFIG_MCA is not set
    CONFIG_HOTPLUG=y

    #
    # PCMCIA/CardBus support
    #
    # CONFIG_PCMCIA is not set

    #
    # PCI Hotplug Support
    #
    # CONFIG_HOTPLUG_PCI is not set
    CONFIG_SYSVIPC=y
    # CONFIG_BSD_PROCESS_ACCT is not set
    CONFIG_SYSCTL=y
    CONFIG_KCORE_ELF=y
    # CONFIG_KCORE_AOUT is not set
    # CONFIG_BINFMT_AOUT is not set
    CONFIG_BINFMT_ELF=y
    CONFIG_BINFMT_MISC=y
    # CONFIG_PM is not set
    # CONFIG_APM_IGNORE_USER_SUSPEND is not set
    # CONFIG_APM_DO_ENABLE is not set
    # CONFIG_APM_CPU_IDLE is not set
    # CONFIG_APM_DISPLAY_BLANK is not set
    # CONFIG_APM_RTC_IS_GMT is not set
    # CONFIG_APM_ALLOW_INTS is not set
    # CONFIG_APM_REAL_MODE_POWER_OFF is not set

    #
    # Memory Technology Devices (MTD)
    #
    # CONFIG_MTD is not set

    #
    # Parallel port support
    #
    CONFIG_PARPORT=m
    CONFIG_PARPORT_PC=m
    CONFIG_PARPORT_PC_CML1=m
    # CONFIG_PARPORT_SERIAL is not set
    # CONFIG_PARPORT_PC_FIFO is not set
    # CONFIG_PARPORT_PC_SUPERIO is not set
    # CONFIG_PARPORT_AMIGA is not set
    # CONFIG_PARPORT_MFC3 is not set
    # CONFIG_PARPORT_ATARI is not set
    # CONFIG_PARPORT_GSC is not set
    # CONFIG_PARPORT_SUNBPP is not set
    CONFIG_PARPORT_OTHER=y
    CONFIG_PARPORT_1284=y

    #
    # Plug and Play configuration
    #
    # CONFIG_PNP is not set

    #
    # Block devices
    #
    CONFIG_BLK_DEV_FD=y
    # CONFIG_BLK_DEV_XD is not set
    # CONFIG_PARIDE is not set
    # CONFIG_BLK_CPQ_DA is not set
    # CONFIG_BLK_CPQ_CISS_DA is not set
    # CONFIG_BLK_DEV_DAC960 is not set
    # CONFIG_BLK_DEV_UMEM is not set
    CONFIG_BLK_DEV_LOOP=y
    # CONFIG_BLK_DEV_NBD is not set
    # CONFIG_BLK_DEV_RAM is not set

    #
    # Multi-device support (RAID and LVM)
    #
    # CONFIG_MD is not set

    #
    # Networking options
    #
    CONFIG_PACKET=y
    CONFIG_PACKET_MMAP=y
    # CONFIG_NETLINK_DEV is not set
    CONFIG_NETFILTER=y
    CONFIG_NETFILTER_DEBUG=y
    CONFIG_FILTER=y
    CONFIG_UNIX=y
    CONFIG_INET=y
    CONFIG_IP_MULTICAST=y
    CONFIG_IP_ADVANCED_ROUTER=y
    CONFIG_IP_MULTIPLE_TABLES=y
    CONFIG_IP_ROUTE_FWMARK=y
    CONFIG_IP_ROUTE_NAT=y
    CONFIG_IP_ROUTE_MULTIPATH=y
    CONFIG_IP_ROUTE_TOS=y
    CONFIG_IP_ROUTE_VERBOSE=y
    CONFIG_IP_ROUTE_LARGE_TABLES=y
    # CONFIG_IP_PNP is not set
    CONFIG_NET_IPIP=m
    CONFIG_NET_IPGRE=m
    CONFIG_NET_IPGRE_BROADCAST=y
    CONFIG_IP_MROUTE=y
    # CONFIG_IP_PIMSM_V1 is not set
    # CONFIG_IP_PIMSM_V2 is not set
    # CONFIG_ARPD is not set
    CONFIG_INET_ECN=y
    CONFIG_SYN_COOKIES=y

    #
    #   IP: Netfilter Configuration
    #
    CONFIG_IP_NF_CONNTRACK=m
    CONFIG_IP_NF_FTP=m
    CONFIG_IP_NF_IRC=m
    CONFIG_IP_NF_QUEUE=m
    CONFIG_IP_NF_IPTABLES=m
    CONFIG_IP_NF_MATCH_LIMIT=m
    CONFIG_IP_NF_MATCH_MAC=m
    CONFIG_IP_NF_MATCH_MARK=m
    CONFIG_IP_NF_MATCH_MULTIPORT=m
    CONFIG_IP_NF_MATCH_TOS=m
    CONFIG_IP_NF_MATCH_AH_ESP=m
    CONFIG_IP_NF_MATCH_LENGTH=m
    CONFIG_IP_NF_MATCH_TTL=m
    CONFIG_IP_NF_MATCH_TCPMSS=m
    CONFIG_IP_NF_MATCH_STATE=m
    CONFIG_IP_NF_MATCH_UNCLEAN=m
    CONFIG_IP_NF_MATCH_OWNER=m
    CONFIG_IP_NF_FILTER=m
    CONFIG_IP_NF_TARGET_REJECT=m
    CONFIG_IP_NF_TARGET_MIRROR=m
    CONFIG_IP_NF_NAT=m
    CONFIG_IP_NF_NAT_NEEDED=y
    CONFIG_IP_NF_TARGET_MASQUERADE=m
    CONFIG_IP_NF_TARGET_REDIRECT=m
    CONFIG_IP_NF_NAT_LOCAL=y
    CONFIG_IP_NF_NAT_SNMP_BASIC=m
    CONFIG_IP_NF_NAT_IRC=m
    CONFIG_IP_NF_NAT_FTP=m
    CONFIG_IP_NF_MANGLE=m
    CONFIG_IP_NF_TARGET_TOS=m
    CONFIG_IP_NF_TARGET_MARK=m
    CONFIG_IP_NF_TARGET_LOG=m
    CONFIG_IP_NF_TARGET_ULOG=m
    CONFIG_IP_NF_TARGET_TCPMSS=m
    CONFIG_IP_NF_ARPTABLES=m
    CONFIG_IP_NF_ARPFILTER=m
    # CONFIG_IP_NF_COMPAT_IPCHAINS is not set
    # CONFIG_IP_NF_COMPAT_IPFWADM is not set
    # CONFIG_IPV6 is not set
    # CONFIG_KHTTPD is not set
    # CONFIG_ATM is not set
    CONFIG_VLAN_8021Q=y

    #
    #  
    #
    # CONFIG_IPX is not set
    # CONFIG_ATALK is not set

    #
    # Appletalk devices
    #
    # CONFIG_DECNET is not set
    # CONFIG_BRIDGE is not set
    # CONFIG_X25 is not set
    # CONFIG_LAPB is not set
    # CONFIG_LLC is not set
    CONFIG_NET_DIVERT=y
    # CONFIG_ECONET is not set
    # CONFIG_WAN_ROUTER is not set
    # CONFIG_NET_FASTROUTE is not set
    # CONFIG_NET_HW_FLOWCONTROL is not set

    #
    # QoS and/or fair queueing
    #
    CONFIG_NET_SCHED=y
    CONFIG_NET_SCH_CBQ=y
    CONFIG_NET_SCH_CSZ=y
    CONFIG_NET_SCH_PRIO=y
    CONFIG_NET_SCH_RED=y
    CONFIG_NET_SCH_SFQ=y
    CONFIG_NET_SCH_TEQL=y
    CONFIG_NET_SCH_TBF=y
    CONFIG_NET_SCH_GRED=y
    CONFIG_NET_SCH_DSMARK=y
    CONFIG_NET_SCH_INGRESS=y
    CONFIG_NET_QOS=y
    CONFIG_NET_ESTIMATOR=y
    CONFIG_NET_CLS=y
    CONFIG_NET_CLS_TCINDEX=y
    CONFIG_NET_CLS_ROUTE4=y
    CONFIG_NET_CLS_ROUTE=y
    CONFIG_NET_CLS_FW=y
    CONFIG_NET_CLS_U32=y
    CONFIG_NET_CLS_RSVP=y
    CONFIG_NET_CLS_RSVP6=y
    CONFIG_NET_CLS_POLICE=y

    #
    # Network testing
    #
    # CONFIG_NET_PKTGEN is not set

    #
    # Telephony Support
    #
    # CONFIG_PHONE is not set

    #
    # ATA/IDE/MFM/RLL support
    #
    CONFIG_IDE=y

    #
    # IDE, ATA and ATAPI Block devices
    #
    CONFIG_BLK_DEV_IDE=y

    #
    # Please see Documentation/ide.txt for help/info on IDE drives
    #
    # CONFIG_BLK_DEV_HD_IDE is not set
    # CONFIG_BLK_DEV_HD is not set
    CONFIG_BLK_DEV_IDEDISK=y
    CONFIG_IDEDISK_MULTI_MODE=y
    # CONFIG_IDEDISK_STROKE is not set
    # CONFIG_BLK_DEV_IDEDISK_VENDOR is not set
    # CONFIG_BLK_DEV_COMMERIAL is not set
    CONFIG_BLK_DEV_IDECD=y
    # CONFIG_BLK_DEV_IDETAPE is not set
    # CONFIG_BLK_DEV_IDEFLOPPY is not set
    CONFIG_BLK_DEV_IDESCSI=m
    # CONFIG_IDE_TASK_IOCTL is not set

    #
    # IDE chipset support/bugfixes
    #
    CONFIG_BLK_DEV_CMD640=y
    # CONFIG_BLK_DEV_CMD640_ENHANCED is not set
    CONFIG_BLK_DEV_RZ1000=y
    CONFIG_BLK_DEV_IDEPCI=y
    CONFIG_IDEPCI_SHARE_IRQ=y
    CONFIG_BLK_DEV_IDEDMA_PCI=y
    # CONFIG_BLK_DEV_OFFBOARD is not set
    # CONFIG_BLK_DEV_IDEDMA_FORCED is not set
    CONFIG_IDEDMA_PCI_AUTO=y
    # CONFIG_IDEDMA_ONLYDISK is not set
    CONFIG_BLK_DEV_IDEDMA=y
    # CONFIG_IDEDMA_PCI_WIP is not set
    CONFIG_BLK_DEV_ADMA=y
    # CONFIG_BLK_DEV_AEC62XX is not set
    # CONFIG_BLK_DEV_ALI15X3 is not set
    CONFIG_BLK_DEV_AMD74XX=y
    # CONFIG_BLK_DEV_CMD64X is not set
    # CONFIG_BLK_DEV_CY82C693 is not set
    # CONFIG_BLK_DEV_CS5530 is not set
    # CONFIG_BLK_DEV_HPT34X is not set
    # CONFIG_BLK_DEV_HPT366 is not set
    CONFIG_BLK_DEV_PIIX=y
    CONFIG_PIIX_TUNING=y
    # CONFIG_BLK_DEV_NS87415 is not set
    # CONFIG_BLK_DEV_OPTI621 is not set
    # CONFIG_BLK_DEV_PDC202XX is not set
    # CONFIG_BLK_DEV_SVWKS is not set
    # CONFIG_BLK_DEV_SIS5513 is not set
    # CONFIG_BLK_DEV_SLC90E66 is not set
    # CONFIG_BLK_DEV_TRM290 is not set
    # CONFIG_BLK_DEV_VIA82CXXX is not set
    # CONFIG_IDE_CHIPSETS is not set
    CONFIG_IDEDMA_AUTO=y
    # CONFIG_IDEDMA_IVB is not set
    # CONFIG_DMA_NONPCI is not set
    CONFIG_BLK_DEV_IDE_MODES=y
    # CONFIG_BLK_DEV_ATARAID is not set

    #
    # SCSI support
    #
    CONFIG_SCSI=m

    #
    # SCSI support type (disk, tape, CD-ROM)
    #
    CONFIG_BLK_DEV_SD=m
    CONFIG_SD_EXTRA_DEVS=40
    # CONFIG_CHR_DEV_ST is not set
    # CONFIG_CHR_DEV_OSST is not set
    CONFIG_BLK_DEV_SR=m
    # CONFIG_BLK_DEV_SR_VENDOR is not set
    CONFIG_SR_EXTRA_DEVS=2
    CONFIG_CHR_DEV_SG=m

    #
    # Some SCSI devices (e.g. CD jukebox) support multiple LUNs
    #
    # CONFIG_SCSI_DEBUG_QUEUES is not set
    # CONFIG_SCSI_MULTI_LUN is not set
    # CONFIG_SCSI_CONSTANTS is not set
    # CONFIG_SCSI_LOGGING is not set

    #
    # SCSI low-level drivers
    #
    # CONFIG_BLK_DEV_3W_XXXX_RAID is not set
    # CONFIG_SCSI_7000FASST is not set
    # CONFIG_SCSI_ACARD is not set
    # CONFIG_SCSI_AHA152X is not set
    # CONFIG_SCSI_AHA1542 is not set
    # CONFIG_SCSI_AHA1740 is not set
    # CONFIG_SCSI_AACRAID is not set
    # CONFIG_SCSI_AIC7XXX is not set
    # CONFIG_SCSI_AIC7XXX_OLD is not set
    # CONFIG_SCSI_DPT_I2O is not set
    # CONFIG_SCSI_ADVANSYS is not set
    # CONFIG_SCSI_IN2000 is not set
    # CONFIG_SCSI_AM53C974 is not set
    # CONFIG_SCSI_MEGARAID is not set
    # CONFIG_SCSI_BUSLOGIC is not set
    # CONFIG_SCSI_CPQFCTS is not set
    # CONFIG_SCSI_DMX3191D is not set
    # CONFIG_SCSI_DTC3280 is not set
    # CONFIG_SCSI_EATA is not set
    # CONFIG_SCSI_EATA_DMA is not set
    # CONFIG_SCSI_EATA_PIO is not set
    # CONFIG_SCSI_FUTURE_DOMAIN is not set
    # CONFIG_SCSI_GDTH is not set
    # CONFIG_SCSI_GENERIC_NCR5380 is not set
    # CONFIG_SCSI_IPS is not set
    # CONFIG_SCSI_INITIO is not set
    # CONFIG_SCSI_INIA100 is not set
    # CONFIG_SCSI_PPA is not set
    # CONFIG_SCSI_IMM is not set
    # CONFIG_SCSI_NCR53C406A is not set
    # CONFIG_SCSI_NCR53C7xx is not set
    # CONFIG_SCSI_SYM53C8XX_2 is not set
    # CONFIG_SCSI_NCR53C8XX is not set
    CONFIG_SCSI_SYM53C8XX=m
    CONFIG_SCSI_NCR53C8XX_DEFAULT_TAGS=4
    CONFIG_SCSI_NCR53C8XX_MAX_TAGS=32
    CONFIG_SCSI_NCR53C8XX_SYNC=20
    # CONFIG_SCSI_NCR53C8XX_PROFILE is not set
    # CONFIG_SCSI_NCR53C8XX_IOMAPPED is not set
    # CONFIG_SCSI_NCR53C8XX_PQS_PDS is not set
    # CONFIG_SCSI_NCR53C8XX_SYMBIOS_COMPAT is not set
    # CONFIG_SCSI_PAS16 is not set
    # CONFIG_SCSI_PCI2000 is not set
    # CONFIG_SCSI_PCI2220I is not set
    # CONFIG_SCSI_PSI240I is not set
    # CONFIG_SCSI_QLOGIC_FAS is not set
    # CONFIG_SCSI_QLOGIC_ISP is not set
    # CONFIG_SCSI_QLOGIC_FC is not set
    # CONFIG_SCSI_QLOGIC_1280 is not set
    # CONFIG_SCSI_SEAGATE is not set
    # CONFIG_SCSI_SIM710 is not set
    # CONFIG_SCSI_SYM53C416 is not set
    # CONFIG_SCSI_DC390T is not set
    # CONFIG_SCSI_T128 is not set
    # CONFIG_SCSI_U14_34F is not set
    # CONFIG_SCSI_ULTRASTOR is not set
    # CONFIG_SCSI_DEBUG is not set

    #
    # Fusion MPT device support
    #
    # CONFIG_FUSION is not set
    # CONFIG_FUSION_BOOT is not set
    # CONFIG_FUSION_ISENSE is not set
    # CONFIG_FUSION_CTL is not set
    # CONFIG_FUSION_LAN is not set

    #
    # IEEE 1394 (FireWire) support (EXPERIMENTAL)
    #
    # CONFIG_IEEE1394 is not set

    #
    # I2O device support
    #
    # CONFIG_I2O is not set

    #
    # Network device support
    #
    CONFIG_NETDEVICES=y

    #
    # ARCnet devices
    #
    # CONFIG_ARCNET is not set
    CONFIG_DUMMY=m
    CONFIG_BONDING=m
    # CONFIG_EQUALIZER is not set
    # CONFIG_TUN is not set
    # CONFIG_ETHERTAP is not set

    #
    # Ethernet (10 or 100Mbit)
    #
    CONFIG_NET_ETHERNET=y
    # CONFIG_HAPPYMEAL is not set
    # CONFIG_SUNGEM is not set
    # CONFIG_NET_VENDOR_3COM is not set
    # CONFIG_LANCE is not set
    # CONFIG_NET_VENDOR_SMC is not set
    # CONFIG_NET_VENDOR_RACAL is not set
    # CONFIG_AT1700 is not set
    CONFIG_DEPCA=m
    # CONFIG_HP100 is not set
    # CONFIG_NET_ISA is not set
    CONFIG_NET_PCI=y
    CONFIG_PCNET32=m
    # CONFIG_ADAPTEC_STARFIRE is not set
    # CONFIG_AC3200 is not set
    # CONFIG_APRICOT is not set
    # CONFIG_CS89x0 is not set
    CONFIG_TULIP=m
    # CONFIG_TC35815 is not set
    # CONFIG_TULIP_MWI is not set
    # CONFIG_TULIP_MMIO is not set
    # CONFIG_DE4X5 is not set
    # CONFIG_DGRS is not set
    # CONFIG_DM9102 is not set
    # CONFIG_EEPRO100 is not set
    # CONFIG_FEALNX is not set
    CONFIG_NATSEMI=m
    # CONFIG_NATSEMI_CABLE_MAGIC is not set
    CONFIG_NE2K_PCI=y
    # CONFIG_8139CP is not set
    CONFIG_8139TOO=m
    CONFIG_8139TOO_PIO=y
    # CONFIG_8139TOO_TUNE_TWISTER is not set
    CONFIG_8139TOO_8129=y
    # CONFIG_8139_NEW_RX_RESET is not set
    CONFIG_SIS900=m
    # CONFIG_EPIC100 is not set
    # CONFIG_SUNDANCE is not set
    # CONFIG_TLAN is not set
    CONFIG_VIA_RHINE=m
    # CONFIG_VIA_RHINE_MMIO is not set
    # CONFIG_WINBOND_840 is not set
    # CONFIG_NET_POCKET is not set

    #
    # Ethernet (1000 Mbit)
    #
    # CONFIG_ACENIC is not set
    # CONFIG_DL2K is not set
    # CONFIG_NS83820 is not set
    # CONFIG_HAMACHI is not set
    # CONFIG_YELLOWFIN is not set
    # CONFIG_SK98LIN is not set
    # CONFIG_TIGON3 is not set
    # CONFIG_FDDI is not set
    # CONFIG_HIPPI is not set
    # CONFIG_PLIP is not set
    CONFIG_PPP=y
    CONFIG_PPP_MULTILINK=y
    CONFIG_PPP_FILTER=y
    CONFIG_PPP_ASYNC=y
    CONFIG_PPP_SYNC_TTY=y
    CONFIG_PPP_DEFLATE=m
    CONFIG_PPP_BSDCOMP=m
    CONFIG_PPPOE=y
    # CONFIG_SLIP is not set

    #
    # Wireless LAN (non-hamradio)
    #
    # CONFIG_NET_RADIO is not set

    #
    # Token Ring devices
    #
    # CONFIG_TR is not set
    # CONFIG_NET_FC is not set
    # CONFIG_RCPCI is not set
    # CONFIG_SHAPER is not set

    #
    # Wan interfaces
    #
    # CONFIG_WAN is not set

    #
    # Amateur Radio support
    #
    # CONFIG_HAMRADIO is not set

    #
    # IrDA (infrared) support
    #
    # CONFIG_IRDA is not set

    #
    # ISDN subsystem
    #
    CONFIG_ISDN=m
    CONFIG_ISDN_BOOL=y
    CONFIG_ISDN_PPP=y
    CONFIG_ISDN_PPP_VJ=y
    CONFIG_ISDN_MPP=y
    CONFIG_ISDN_PPP_BSDCOMP=m
    # CONFIG_ISDN_AUDIO is not set

    #
    # ISDN feature submodules
    #
    # CONFIG_ISDN_DRV_LOOP is not set
    # CONFIG_ISDN_DIVERSION is not set

    #
    # low-level hardware drivers
    #

    #
    # Passive ISDN cards
    #
    CONFIG_ISDN_DRV_HISAX=m
    CONFIG_ISDN_HISAX=y

    #
    #   D-channel protocol features
    #
    CONFIG_HISAX_EURO=y
    # CONFIG_DE_AOC is not set
    # CONFIG_HISAX_NO_SENDCOMPLETE is not set
    # CONFIG_HISAX_NO_LLC is not set
    # CONFIG_HISAX_NO_KEYPAD is not set
    # CONFIG_HISAX_1TR6 is not set
    # CONFIG_HISAX_NI1 is not set
    CONFIG_HISAX_MAX_CARDS=8

    #
    #   HiSax supported cards
    #
    # CONFIG_HISAX_16_0 is not set
    # CONFIG_HISAX_16_3 is not set
    # CONFIG_HISAX_TELESPCI is not set
    # CONFIG_HISAX_S0BOX is not set
    # CONFIG_HISAX_AVM_A1 is not set
    # CONFIG_HISAX_FRITZPCI is not set
    # CONFIG_HISAX_AVM_A1_PCMCIA is not set
    # CONFIG_HISAX_ELSA is not set
    # CONFIG_HISAX_IX1MICROR2 is not set
    # CONFIG_HISAX_DIEHLDIVA is not set
    # CONFIG_HISAX_ASUSCOM is not set
    # CONFIG_HISAX_TELEINT is not set
    # CONFIG_HISAX_HFCS is not set
    # CONFIG_HISAX_SEDLBAUER is not set
    # CONFIG_HISAX_SPORTSTER is not set
    # CONFIG_HISAX_MIC is not set
    CONFIG_HISAX_NETJET=y
    # CONFIG_HISAX_NETJET_U is not set
    # CONFIG_HISAX_NICCY is not set
    # CONFIG_HISAX_ISURF is not set
    # CONFIG_HISAX_HSTSAPHIR is not set
    # CONFIG_HISAX_BKM_A4T is not set
    # CONFIG_HISAX_SCT_QUADRO is not set
    # CONFIG_HISAX_GAZEL is not set
    # CONFIG_HISAX_HFC_PCI is not set
    # CONFIG_HISAX_W6692 is not set
    # CONFIG_HISAX_HFC_SX is not set
    # CONFIG_HISAX_DEBUG is not set
    # CONFIG_HISAX_ST5481 is not set
    # CONFIG_HISAX_FRITZ_PCIPNP is not set

    #
    # Active ISDN cards
    #
    # CONFIG_ISDN_DRV_ICN is not set
    # CONFIG_ISDN_DRV_PCBIT is not set
    # CONFIG_ISDN_DRV_SC is not set
    # CONFIG_ISDN_DRV_ACT2000 is not set
    # CONFIG_ISDN_DRV_EICON is not set
    # CONFIG_ISDN_DRV_TPAM is not set
    # CONFIG_ISDN_CAPI is not set
    # CONFIG_HYSDN is not set

    #
    # Old CD-ROM drivers (not SCSI, not IDE)
    #
    # CONFIG_CD_NO_IDESCSI is not set

    #
    # Input core support
    #
    CONFIG_INPUT=m
    CONFIG_INPUT_KEYBDEV=m
    CONFIG_INPUT_MOUSEDEV=m
    CONFIG_INPUT_MOUSEDEV_SCREEN_X=1024
    CONFIG_INPUT_MOUSEDEV_SCREEN_Y=768
    CONFIG_INPUT_JOYDEV=m
    # CONFIG_INPUT_EVDEV is not set

    #
    # Character devices
    #
    CONFIG_VT=y
    CONFIG_VT_CONSOLE=y
    CONFIG_SERIAL=y
    CONFIG_SERIAL_CONSOLE=y
    CONFIG_SERIAL_EXTENDED=y
    # CONFIG_SERIAL_MANY_PORTS is not set
    CONFIG_SERIAL_SHARE_IRQ=y
    # CONFIG_SERIAL_DETECT_IRQ is not set
    # CONFIG_SERIAL_MULTIPORT is not set
    # CONFIG_HUB6 is not set
    # CONFIG_SERIAL_NONSTANDARD is not set
    CONFIG_UNIX98_PTYS=y
    CONFIG_UNIX98_PTY_COUNT=256
    CONFIG_PRINTER=m
    # CONFIG_LP_CONSOLE is not set
    # CONFIG_PPDEV is not set

    #
    # I2C support
    #
    # CONFIG_I2C is not set

    #
    # Mice
    #
    # CONFIG_BUSMOUSE is not set
    CONFIG_MOUSE=y
    CONFIG_PSMOUSE=y
    # CONFIG_82C710_MOUSE is not set
    # CONFIG_PC110_PAD is not set
    # CONFIG_MK712_MOUSE is not set

    #
    # Joysticks
    #
    CONFIG_INPUT_GAMEPORT=m
    # CONFIG_INPUT_NS558 is not set
    # CONFIG_INPUT_LIGHTNING is not set
    # CONFIG_INPUT_PCIGAME is not set
    # CONFIG_INPUT_CS461X is not set
    CONFIG_INPUT_EMU10K1=m
    CONFIG_INPUT_SERIO=m
    CONFIG_INPUT_SERPORT=m

    #
    # Joysticks
    #
    CONFIG_INPUT_ANALOG=m
    # CONFIG_INPUT_A3D is not set
    # CONFIG_INPUT_ADI is not set
    # CONFIG_INPUT_COBRA is not set
    # CONFIG_INPUT_GF2K is not set
    # CONFIG_INPUT_GRIP is not set
    # CONFIG_INPUT_INTERACT is not set
    # CONFIG_INPUT_TMDC is not set
    # CONFIG_INPUT_SIDEWINDER is not set
    # CONFIG_INPUT_IFORCE_USB is not set
    # CONFIG_INPUT_IFORCE_232 is not set
    # CONFIG_INPUT_WARRIOR is not set
    # CONFIG_INPUT_MAGELLAN is not set
    # CONFIG_INPUT_SPACEORB is not set
    # CONFIG_INPUT_SPACEBALL is not set
    # CONFIG_INPUT_STINGER is not set
    # CONFIG_INPUT_DB9 is not set
    # CONFIG_INPUT_GAMECON is not set
    # CONFIG_INPUT_TURBOGRAFX is not set
    # CONFIG_QIC02_TAPE is not set

    #
    # Watchdog Cards
    #
    # CONFIG_WATCHDOG is not set
    # CONFIG_AMD_RNG is not set
    # CONFIG_INTEL_RNG is not set
    # CONFIG_NVRAM is not set
    CONFIG_RTC=y
    # CONFIG_DTLK is not set
    # CONFIG_R3964 is not set
    # CONFIG_APPLICOM is not set
    # CONFIG_SONYPI is not set

    #
    # Ftape, the floppy tape device driver
    #
    # CONFIG_FTAPE is not set
    CONFIG_AGP=y
    CONFIG_AGP_INTEL=y
    CONFIG_AGP_I810=y
    CONFIG_AGP_VIA=y
    CONFIG_AGP_AMD=y
    CONFIG_AGP_SIS=y
    CONFIG_AGP_ALI=y
    # CONFIG_AGP_SWORKS is not set
    CONFIG_DRM=y
    # CONFIG_DRM_OLD is not set

    #
    # DRM 4.1 drivers
    #
    CONFIG_DRM_NEW=y
    # CONFIG_DRM_TDFX is not set
    # CONFIG_DRM_R128 is not set
    # CONFIG_DRM_RADEON is not set
    # CONFIG_DRM_I810 is not set
    # CONFIG_DRM_MGA is not set
    # CONFIG_DRM_SIS is not set
    # CONFIG_MWAVE is not set

    #
    # Multimedia devices
    #
    # CONFIG_VIDEO_DEV is not set

    #
    # File systems
    #
    # CONFIG_QUOTA is not set
    # CONFIG_AUTOFS_FS is not set
    CONFIG_AUTOFS4_FS=y
    # CONFIG_REISERFS_FS is not set
    # CONFIG_ADFS_FS is not set
    # CONFIG_AFFS_FS is not set
    # CONFIG_HFS_FS is not set
    # CONFIG_BFS_FS is not set
    CONFIG_EXT3_FS=y
    CONFIG_JBD=y
    # CONFIG_JBD_DEBUG is not set
    CONFIG_FAT_FS=y
    CONFIG_MSDOS_FS=y
    # CONFIG_UMSDOS_FS is not set
    CONFIG_VFAT_FS=y
    # CONFIG_EFS_FS is not set
    # CONFIG_CRAMFS is not set
    CONFIG_TMPFS=y
    CONFIG_RAMFS=y
    CONFIG_ISO9660_FS=y
    CONFIG_JOLIET=y
    # CONFIG_ZISOFS is not set
    CONFIG_MINIX_FS=y
    # CONFIG_VXFS_FS is not set
    # CONFIG_NTFS_FS is not set
    # CONFIG_HPFS_FS is not set
    CONFIG_PROC_FS=y
    CONFIG_DEVFS_FS=y
    CONFIG_DEVFS_MOUNT=y
    # CONFIG_DEVFS_DEBUG is not set
    CONFIG_DEVPTS_FS=y
    # CONFIG_QNX4FS_FS is not set
    # CONFIG_ROMFS_FS is not set
    CONFIG_EXT2_FS=y
    # CONFIG_SYSV_FS is not set
    CONFIG_UDF_FS=m
    # CONFIG_UDF_RW is not set
    # CONFIG_UFS_FS is not set

    #
    # Network File Systems
    #
    # CONFIG_CODA_FS is not set
    # CONFIG_INTERMEZZO_FS is not set
    CONFIG_NFS_FS=y
    # CONFIG_NFS_V3 is not set
    CONFIG_NFSD=y
    # CONFIG_NFSD_V3 is not set
    CONFIG_SUNRPC=y
    CONFIG_LOCKD=y
    CONFIG_SMB_FS=y
    # CONFIG_SMB_NLS_DEFAULT is not set
    # CONFIG_NCP_FS is not set
    # CONFIG_ZISOFS_FS is not set
    # CONFIG_ZLIB_FS_INFLATE is not set

    #
    # Partition Types
    #
    # CONFIG_PARTITION_ADVANCED is not set
    CONFIG_MSDOS_PARTITION=y
    CONFIG_SMB_NLS=y
    CONFIG_NLS=y

    #
    # Native Language Support
    #
    CONFIG_NLS_DEFAULT="iso8859-1"
    CONFIG_NLS_CODEPAGE_437=m
    # CONFIG_NLS_CODEPAGE_737 is not set
    # CONFIG_NLS_CODEPAGE_775 is not set
    # CONFIG_NLS_CODEPAGE_850 is not set
    # CONFIG_NLS_CODEPAGE_852 is not set
    # CONFIG_NLS_CODEPAGE_855 is not set
    # CONFIG_NLS_CODEPAGE_857 is not set
    # CONFIG_NLS_CODEPAGE_860 is not set
    # CONFIG_NLS_CODEPAGE_861 is not set
    # CONFIG_NLS_CODEPAGE_862 is not set
    # CONFIG_NLS_CODEPAGE_863 is not set
    # CONFIG_NLS_CODEPAGE_864 is not set
    # CONFIG_NLS_CODEPAGE_865 is not set
    # CONFIG_NLS_CODEPAGE_866 is not set
    # CONFIG_NLS_CODEPAGE_869 is not set
    # CONFIG_NLS_CODEPAGE_936 is not set
    # CONFIG_NLS_CODEPAGE_950 is not set
    # CONFIG_NLS_CODEPAGE_932 is not set
    # CONFIG_NLS_CODEPAGE_949 is not set
    # CONFIG_NLS_CODEPAGE_874 is not set
    # CONFIG_NLS_ISO8859_8 is not set
    # CONFIG_NLS_CODEPAGE_1250 is not set
    # CONFIG_NLS_CODEPAGE_1251 is not set
    # CONFIG_NLS_ISO8859_1 is not set
    # CONFIG_NLS_ISO8859_2 is not set
    # CONFIG_NLS_ISO8859_3 is not set
    # CONFIG_NLS_ISO8859_4 is not set
    # CONFIG_NLS_ISO8859_5 is not set
    # CONFIG_NLS_ISO8859_6 is not set
    # CONFIG_NLS_ISO8859_7 is not set
    # CONFIG_NLS_ISO8859_9 is not set
    # CONFIG_NLS_ISO8859_13 is not set
    # CONFIG_NLS_ISO8859_14 is not set
    # CONFIG_NLS_ISO8859_15 is not set
    # CONFIG_NLS_KOI8_R is not set
    # CONFIG_NLS_KOI8_U is not set
    # CONFIG_NLS_UTF8 is not set

    #
    # Console drivers
    #
    CONFIG_VGA_CONSOLE=y
    # CONFIG_VIDEO_SELECT is not set
    # CONFIG_MDA_CONSOLE is not set

    #
    # Frame-buffer support
    #
    # CONFIG_FB is not set

    #
    # Sound
    #
    CONFIG_SOUND=m
    # CONFIG_SOUND_BT878 is not set
    # CONFIG_SOUND_CMPCI is not set
    # CONFIG_SOUND_EMU10K1 is not set
    # CONFIG_SOUND_FUSION is not set
    # CONFIG_SOUND_CS4281 is not set
    # CONFIG_SOUND_ES1370 is not set
    # CONFIG_SOUND_ES1371 is not set
    # CONFIG_SOUND_ESSSOLO1 is not set
    # CONFIG_SOUND_MAESTRO is not set
    # CONFIG_SOUND_MAESTRO3 is not set
    # CONFIG_SOUND_ICH is not set
    # CONFIG_SOUND_RME96XX is not set
    # CONFIG_SOUND_SONICVIBES is not set
    # CONFIG_SOUND_TRIDENT is not set
    # CONFIG_SOUND_MSNDCLAS is not set
    # CONFIG_SOUND_MSNDPIN is not set
    # CONFIG_SOUND_VIA82CXXX is not set
    # CONFIG_SOUND_OSS is not set

    #
    # USB support
    #
    CONFIG_USB=m
    # CONFIG_USB_DEBUG is not set

    #
    # Miscellaneous USB options
    #
    # CONFIG_USB_DEVICEFS is not set
    # CONFIG_USB_BANDWIDTH is not set
    # CONFIG_USB_LONG_TIMEOUT is not set

    #
    # USB Host Controller Drivers
    #
    # CONFIG_USB_EHCI_HCD is not set
    # CONFIG_USB_UHCI is not set
    # CONFIG_USB_UHCI_ALT is not set
    # CONFIG_USB_OHCI is not set

    #
    # USB Device Class drivers
    #
    CONFIG_USB_AUDIO=m
    # CONFIG_USB_EMI26 is not set
    # CONFIG_USB_BLUETOOTH is not set
    # CONFIG_USB_STORAGE is not set
    # CONFIG_USB_ACM is not set
    # CONFIG_USB_PRINTER is not set

    #
    # USB Human Interface Devices (HID)
    #
    # CONFIG_USB_HID is not set
    # CONFIG_USB_KBD is not set
    # CONFIG_USB_MOUSE is not set
    # CONFIG_USB_WACOM is not set

    #
    # USB Imaging devices
    #
    # CONFIG_USB_DC2XX is not set
    # CONFIG_USB_MDC800 is not set
    # CONFIG_USB_SCANNER is not set
    # CONFIG_USB_MICROTEK is not set
    # CONFIG_USB_HPUSBSCSI is not set

    #
    # USB Multimedia devices
    #

    #
    #   Video4Linux support is needed for USB Multimedia device support
    #

    #
    # USB Network adaptors
    #
    # CONFIG_USB_PEGASUS is not set
    # CONFIG_USB_RTL8150 is not set
    # CONFIG_USB_KAWETH is not set
    # CONFIG_USB_CATC is not set
    # CONFIG_USB_CDCETHER is not set
    # CONFIG_USB_USBNET is not set

    #
    # USB port drivers
    #
    # CONFIG_USB_USS720 is not set

    #
    # USB Serial Converter support
    #
    # CONFIG_USB_SERIAL is not set

    #
    # USB Miscellaneous drivers
    #
    # CONFIG_USB_RIO500 is not set
    # CONFIG_USB_AUERSWALD is not set
    # CONFIG_USB_BRLVGER is not set

    #
    # Bluetooth support
    #
    # CONFIG_BLUEZ is not set

    #
    # Kernel hacking
    #
    CONFIG_DEBUG_KERNEL=y
    # CONFIG_DEBUG_HIGHMEM is not set
    # CONFIG_DEBUG_SLAB is not set
    # CONFIG_DEBUG_IOVIRT is not set
    CONFIG_MAGIC_SYSRQ=y
    # CONFIG_DEBUG_SPINLOCK is not set
    # CONFIG_FRAME_POINTER is not set

Retrieved from
"[http://alsa.opensrc.org/AlsaBuildConfig](http://alsa.opensrc.org/AlsaBuildConfig)"

[Category](/Special:Categories "Special:Categories"):
[Installation](/Category:Installation "Category:Installation")

