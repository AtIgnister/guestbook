#!/usr/bin/env bash

REQ_FILE="requirements.txt"

if [[ ! -f "$REQ_FILE" ]]; then
    echo "requirements.txt not found! Try to re-download the git repository, it should be there."
    echo "If you can't find it, email the maintainer."
    exit 1
fi

# Detect package manager
detect_pkg_manager() {

    if command -v apt-get >/dev/null; then
        PKG_MANAGER="apt"
    elif command -v dnf >/dev/null; then
        PKG_MANAGER="dnf"
    elif command -v pacman >/dev/null; then
        PKG_MANAGER="pacman"
    elif command -v zypper >/dev/null; then
        PKG_MANAGER="zypper"
    else
        echo "Unsupported package manager."
        exit 1
    fi
}

update_db() {

    echo "Updating package database..."

    case "$PKG_MANAGER" in
        apt)
            sudo apt-get update
            ;;
        dnf)
            sudo dnf check-update
            ;;
        pacman)
            sudo pacman -Sy
            ;;
        zypper)
            sudo zypper refresh
            ;;
    esac
}

install_pkg() {

    pkg="$1"

    case "$PKG_MANAGER" in
        apt)
            sudo apt-get install -y "$pkg"
            ;;
        dnf)
            sudo dnf install -y "$pkg"
            ;;
        pacman)
            sudo pacman -S --noconfirm "$pkg"
            ;;
        zypper)
            sudo zypper install -y "$pkg"
            ;;
    esac
}

check_dependency() {

    cmd="$1"
    pkg="$2"

    if command -v "$cmd" >/dev/null 2>&1; then
        echo "[OK] $cmd"
    else
        echo "[MISSING] $cmd → installing package '$pkg'"
        install_pkg "$pkg"

        if command -v "$cmd" >/dev/null 2>&1; then
            echo "[INSTALLED] $cmd"
        else
            echo "[FAILED] $cmd still not available"
        fi
    fi
}

detect_pkg_manager
update_db

echo
echo "Checking dependencies..."
echo

while IFS= read -r line || [[ -n "$line" ]]; do

    [[ -z "$line" || "$line" =~ ^# ]] && continue

    cmd=$(echo "$line" | cut -d':' -f1)
    pkg=$(echo "$line" | cut -d':' -f2)

    check_dependency "$cmd" "$pkg"

done < "$REQ_FILE"

echo
echo "Dependency check complete."