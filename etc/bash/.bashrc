[ -f "$ENV" ] && [ -z "$ENV_LOADED" ] && source "$ENV" &>/dev/null && ENV_LOADED=1

if [ -f ~/.bash_aliases ]; then
    . ~/.bash_aliases
fi
