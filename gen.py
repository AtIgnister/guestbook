import subprocess
import string
import pathlib

OUTPUT_DIR = pathlib.Path("storage/app/captcha/letters/")
VOICE = "en"          # try: en-us, en-gb, etc.
SPEED = "140"         # words per minute (lower = slower)
PITCH = "50"          # 0–99
VOLUME = "200"        # amplitude

OUTPUT_DIR.mkdir(exist_ok=True)

def generate_mp3(text, filename):
    wav_path = OUTPUT_DIR / f"{filename}.wav"
    mp3_path = OUTPUT_DIR / f"{filename}.mp3"

    # Generate WAV using eSpeak NG
    subprocess.run([
        "espeak-ng",
        "-v", VOICE,
        "-s", SPEED,
        "-p", PITCH,
        "-a", VOLUME,
        "-w", str(wav_path),
        text
    ], check=True)

    # Convert WAV → MP3
    subprocess.run([
        "ffmpeg",
        "-y",
        "-loglevel", "error",
        "-i", str(wav_path),
        "-codec:a", "libmp3lame",
        "-b:a", "64k",
        str(mp3_path)
    ], check=True)

    wav_path.unlink()  # remove WAV after conversion

# Letters A–Z
for letter in string.ascii_uppercase:
    generate_mp3(letter, letter.lower())

# Digits 0–9 (spoken as words for clarity)
digit_words = {
    "0": "zero",
    "1": "one",
    "2": "two",
    "3": "three",
    "4": "four",
    "5": "five",
    "6": "six",
    "7": "seven",
    "8": "eight",
    "9": "nine",
}

generate_mp3('dash','-');

for digit, word in digit_words.items():
    generate_mp3(word, digit)

print("Done! MP3 files are in " + str(OUTPUT_DIR))
