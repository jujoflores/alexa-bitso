# alexa-bitso

This is an Alexa skill to get current value of cryptocurrencies provided by Bitso exchange

# How to install 

Clone the repository

```
git clone https://github.com/jujoflores/alexa-bitso.git
```

Install dependencies

```
composer install
```

Run ngrok

```
ngrok http 80
```

# Amazon Developer Configuration

## Intent Schema

```
{
  "intents": [
    {
      "intent": "CurrentIntent"
    },
    {
      "slots": [
        {
          "name": "CurrencyName",
          "type": "CURRENCY_NAME"
        }
      ],
      "intent": "CurrencyIntent"
    },
    {
      "intent": "AMAZON.StopIntent"
    },
    {
      "intent": "AMAZON.CancelIntent"
    },
    {
      "intent": "AMAZON.HelpIntent"
    }
  ]
}
```

## Slots

```
CURRENCY_NAME		Bitcoin | Ethereum | Ripple
```

## Utterances

```
CurrentIntent What are the current prices
CurrentIntent What are the latest prices
CurrentIntent What's up
CurrentIntent What's new
CurrentIntent give me all
CurrencyIntent Give me last price for {CurrencyName}
CurrencyIntent Current price for {CurrencyName}
CurrencyIntent Last price for {CurrencyName}
CurrencyIntent {CurrencyName}

```

## Link the skill to your code

Rename `.env.sample` file to `.env`

Write the Amazon Skill ID

```
SKILL_ID="AMAZON_SKILL_ID"
```
