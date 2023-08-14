# PERSCOM CLI Tool - Manage Personnel Data with Ease

The PERSCOM Command Line Interface (CLI) Tool offers a streamlined approach to interact with your PERSCOM data efficiently.

## Prerequisites

To utilize the PERSCOM CLI, an active account at [https://perscom.io](https://perscom.io) is essential.

## Usage

The PERSCOM CLI can be accessed and executed through various methods, each presenting distinct advantages and trade-offs. Opt for the approach that aligns best with your requirements.

### Docker Method

Retrieve the Docker image from the registry.

```bash
docker pull ghcr.io/deschutesdesigngroupllc/perscom
```

Execute the PERSCOM CLI using this command.

```bash
docker run --rm -it ghcr.io/deschutesdesigngroupllc/perscom <command> [options] [arguments]
```

### PHAR Method

The fundamental form of the PERSCOM CLI is a PHAR file. Acquire the latest build from the GitHub releases repository.

```bash
wget https://github.com/DeschutesDesignGroupLLC/perscom-cli/releases/latest/download/perscom
```

Adjust the executable's permissions.

```bash
chmod +x perscom
```

Execute the PERSCOM CLI.

```bash
php perscom <command> [options] [arguments]
```

## Commands

Discover the list of commands using the `list` command.

**Docker**:
```bash
docker run --rm -it ghcr.io/deschutesdesigngroupllc/perscom list
```

**PHAR**:
```bash
php perscom list
```

## Help

For each command, valuable instructions are accessible via the `--help` argument.

**Docker**:
```bash
docker run --rm -it ghcr.io/deschutesdesigngroupllc/perscom <command> --help
```

**PHAR**:
```bash
php perscom <command> --help
```

## Documentation

Further documentation can be reach at [https://docs.perscom.io](https://docs.perscom.io).
